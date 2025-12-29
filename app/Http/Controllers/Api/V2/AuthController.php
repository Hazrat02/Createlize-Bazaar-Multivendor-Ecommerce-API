<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V2\LoginRequest;
use App\Http\Requests\Api\V2\RegisterRequest;
use App\Models\User;
use App\Services\Settings\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
        ]);

        $user->assignRole('Customer');
        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'user' => $this->presentUser($user),
            'token' => $token,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::query()->where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['email' => 'Invalid credentials.']);
        }

        if ($user->status === 'banned') {
            throw ValidationException::withMessages(['email' => 'Account is banned.']);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'user' => $this->presentUser($user),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json(['ok' => true]);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return response()->json($this->presentUser($user));
    }

    public function googleRedirect(Request $request, SettingsService $settings)
    {
        if (!$this->googleEnabled($settings)) {
            abort(404);
        }

        $clientId = (string)$settings->get('auth_google', 'client_id', '');
        $redirectUrl = (string)$settings->get('auth_google', 'redirect_url', route('api.v2.auth.google.callback'));

        if (!$clientId || !$redirectUrl) {
            abort(404);
        }

        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        $params = [
            'client_id' => $clientId,
            'redirect_uri' => $redirectUrl,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'access_type' => 'online',
            'state' => $state,
            'prompt' => 'select_account',
        ];

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params));
    }

    public function googleCallback(Request $request, SettingsService $settings)
    {
        if (!$this->googleEnabled($settings)) {
            return redirect()->away($this->googleFrontendRedirect($settings, 'Google login disabled.'));
        }

        $state = (string)$request->query('state');
        $expected = (string)$request->session()->pull('google_oauth_state');
        if (!$state || $state !== $expected) {
            return redirect()->away($this->googleFrontendRedirect($settings, 'Invalid login state.'));
        }

        $code = (string)$request->query('code');
        if (!$code) {
            return redirect()->away($this->googleFrontendRedirect($settings, 'Authorization code missing.'));
        }

        $clientId = (string)$settings->get('auth_google', 'client_id', '');
        $clientSecret = (string)$settings->get('auth_google', 'client_secret', '');
        $redirectUrl = (string)$settings->get('auth_google', 'redirect_url', route('api.v2.auth.google.callback'));

        if (!$clientId || !$clientSecret || !$redirectUrl) {
            return redirect()->away($this->googleFrontendRedirect($settings, 'Google credentials missing.'));
        }

        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUrl,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ]);

        if (!$tokenResponse->successful()) {
            return redirect()->away($this->googleFrontendRedirect($settings, 'Google token request failed.'));
        }

        $accessToken = $tokenResponse->json('access_token');
        if (!$accessToken) {
            return redirect()->away($this->googleFrontendRedirect($settings, 'Google token missing.'));
        }

        $profileResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo');
        if (!$profileResponse->successful()) {
            return redirect()->away($this->googleFrontendRedirect($settings, 'Google profile request failed.'));
        }

        $profile = $profileResponse->json();
        $email = $profile['email'] ?? null;
        $googleId = $profile['sub'] ?? null;
        $name = $profile['name'] ?? null;

        if (!$email || !$googleId) {
            return redirect()->away($this->googleFrontendRedirect($settings, 'Google profile incomplete.'));
        }

        $user = User::query()
            ->where('email', $email)
            ->orWhere('google_id', $googleId)
            ->first();

        if (!$user) {
            $user = User::create([
                'name' => $name ?: $email,
                'email' => $email,
                'password' => Hash::make(Str::random(32)),
                'status' => 'active',
                'google_id' => $googleId,
            ]);
            $user->assignRole('Customer');
        } else {
            if (!$user->google_id) {
                $user->update(['google_id' => $googleId]);
            }
        }

        if ($user->status === 'banned') {
            return redirect()->away($this->googleFrontendRedirect($settings, 'Account is banned.'));
        }

        // Issue token for SPA use
        $token = $user->createToken('api')->plainTextToken;
        $redirectUrl = $this->googleFrontendRedirect($settings);
        $separator = str_contains($redirectUrl, '?') ? '&' : '?';

        return redirect()->away($redirectUrl . $separator . 'token=' . urlencode($token));
    }

    private function presentUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
            'roles' => $user->getRoleNames(),
        ];
    }

    private function googleEnabled(SettingsService $settings): bool
    {
        return (bool)$settings->get('auth_google', 'enabled', false);
    }

    private function googleFrontendRedirect(SettingsService $settings, ?string $error = null): string
    {
        $url = (string)$settings->get('auth_google', 'frontend_redirect_url', config('app.url'));
        if (!$error) {
            return $url;
        }

        $separator = str_contains($url, '?') ? '&' : '?';
        return $url . $separator . 'auth_error=' . urlencode($error);
    }
}
