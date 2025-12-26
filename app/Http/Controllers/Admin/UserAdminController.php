<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Services\Settings\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class UserAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $query = User::query()->with('roles')->latest();

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return Inertia::render('Admin/Users/Index', [
            'users' => $query->paginate(20)->withQueryString(),
            'filters' => $request->only('q'),
            'googleSettings' => $this->googleSettings(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Users/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:150'],
            'email' => ['required','email','max:190','unique:users,email'],
            'password' => ['required','string','min:6'],
            'status' => ['required','in:active,banned'],
            'role' => ['required','in:Admin,Vendor,Customer'],
            'profile_image' => ['required','image','max:4096'],
        ]);

        $path = $data['profile_image']->store('users', 'public');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'profile_image' => $path,
            'password' => bcrypt($data['password']),
            'status' => $data['status'],
        ]);
        $user->assignRole($data['role']);

        return redirect()->route('admin.users.index')->with('success','User created');
    }

    public function edit(User $user): Response
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user->load('roles'),
            'roles' => $user->getRoleNames(),
        ]);
    }

    public function show(User $user): Response
    {
        $user->load(['roles','vendorProfile']);

        $orders = Order::query()
            ->where('customer_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        $payments = Order::query()
            ->where('customer_id', $user->id)
            ->latest()
            ->limit(10)
            ->get(['id','order_number','total','payment_status','payment_method','created_at']);

        return Inertia::render('Admin/Users/Show', [
            'user' => $user,
            'orders' => $orders,
            'payments' => $payments,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:150'],
            'email' => ['required','email','max:190','unique:users,email,'.$user->id],
            'password' => ['nullable','string','min:6'],
            'status' => ['required','in:active,banned'],
            'role' => ['required','in:Admin,Vendor,Customer'],
            'profile_image' => ['nullable','image','max:4096'],
        ]);

        $profileImagePath = $user->profile_image;
        if (!empty($data['profile_image'])) {
            if ($profileImagePath) {
                Storage::disk('public')->delete($profileImagePath);
            }
            $profileImagePath = $data['profile_image']->store('users', 'public');
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'profile_image' => $profileImagePath,
            'status' => $data['status'],
            'password' => $data['password'] ? bcrypt($data['password']) : $user->password,
        ]);

        $user->syncRoles([$data['role']]);

        return redirect()->route('admin.users.index')->with('success','User updated');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted');
    }

    public function ban(User $user): RedirectResponse
    {
        $user->update(['status' => 'banned']);
        return back()->with('success','User banned');
    }

    public function unban(User $user): RedirectResponse
    {
        $user->update(['status' => 'active']);
        return back()->with('success','User unbanned');
    }

    public function sendMail(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'subject' => ['required','string','max:150'],
            'message' => ['required','string'],
        ]);

        $smtp = Setting::query()->where('key', 'smtp')->first()?->value;
        if (!$smtp) {
            return back()->with('error', 'SMTP settings not configured.');
        }

        config()->set('mail.default', $smtp['mailer'] ?? 'smtp');
        config()->set('mail.mailers.smtp.host', $smtp['host'] ?? '');
        config()->set('mail.mailers.smtp.port', $smtp['port'] ?? 587);
        config()->set('mail.mailers.smtp.username', $smtp['username'] ?? null);
        config()->set('mail.mailers.smtp.password', $smtp['password'] ?? null);
        config()->set('mail.mailers.smtp.encryption', $smtp['encryption'] ?? null);
        config()->set('mail.from.address', $smtp['from_address'] ?? 'no-reply@example.com');
        config()->set('mail.from.name', $smtp['from_name'] ?? 'Admin');

        $templateSubject = $smtp['template_subject'] ?? null;
        $templateBody = $smtp['template_body'] ?? null;

        $subject = $templateSubject ?: $data['subject'];
        $body = $templateBody ?: nl2br(e($data['message']));

        $replace = [
            '{{name}}' => $user->name,
            '{{email}}' => $user->email,
            '{{subject}}' => $data['subject'],
            '{{message}}' => nl2br(e($data['message'])),
        ];
        $subject = strtr($subject, $replace);
        $body = strtr($body, $replace);

        Mail::send([], [], function ($mail) use ($subject, $body, $user) {
            $mail->to($user->email)
                ->subject($subject)
                ->html($body);
        });

        return back()->with('success', 'Email sent');
    }

    public function updateGoogleSettings(Request $request, SettingsService $settingsService): RedirectResponse
    {
        $data = $request->validate([
            'enabled' => ['nullable', 'boolean'],
            'client_id' => ['nullable', 'string', 'max:255'],
            'client_secret' => ['nullable', 'string', 'max:255'],
            'redirect_url' => ['nullable', 'url', 'max:500'],
            'frontend_redirect_url' => ['nullable', 'url', 'max:500'],
        ]);

        $settingsService->set('auth_google', 'enabled', (bool)($data['enabled'] ?? false));
        $settingsService->set('auth_google', 'client_id', $data['client_id'] ?? '');
        $settingsService->set('auth_google', 'client_secret', $data['client_secret'] ?? '');
        $settingsService->set('auth_google', 'redirect_url', $data['redirect_url'] ?? route('api.v2.auth.google.callback'));
        $settingsService->set('auth_google', 'frontend_redirect_url', $data['frontend_redirect_url'] ?? config('app.url'));

        return back()->with('success', 'Google login settings saved');
    }

    private function googleSettings(): array
    {
        $settings = Setting::query()
            ->where('group', 'auth_google')
            ->pluck('value', 'key')
            ->toArray();

        return [
            'enabled' => (bool)($settings['enabled'] ?? false),
            'client_id' => (string)($settings['client_id'] ?? ''),
            'client_secret' => (string)($settings['client_secret'] ?? ''),
            'redirect_url' => (string)($settings['redirect_url'] ?? route('api.v2.auth.google.callback')),
            'frontend_redirect_url' => (string)($settings['frontend_redirect_url'] ?? config('app.url')),
        ];
    }
}
