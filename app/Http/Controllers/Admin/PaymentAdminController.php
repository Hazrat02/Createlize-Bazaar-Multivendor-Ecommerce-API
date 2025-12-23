<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\Settings\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PaymentAdminController extends Controller
{
    public function __construct(private SettingsService $settingsService) {}

    public function edit(): Response
    {
        $settings = $this->settingsService->group('payment_uddoktapay');
        if (!$settings) {
            $legacy = Setting::query()->where('key','payment.uddoktapay')->first();
            $settings = $legacy?->value ?? [];
        }

        return Inertia::render('Admin/Payments/UddoktaPay', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mode' => ['required','in:sandbox,live'],
            'sandbox_base_url' => ['nullable','string'],
            'sandbox_api_key' => ['nullable','string'],
            'sandbox_secret' => ['nullable','string'],
            'redirect_url' => ['nullable','string'],
            'cancel_url' => ['nullable','string'],
            'live_base_url' => ['nullable','string'],
            'live_api_key' => ['nullable','string'],
            'live_secret' => ['nullable','string'],
        ]);

        foreach ($data as $key => $value) {
            $this->settingsService->set('payment_uddoktapay', $key, $value);
        }

        return back()->with('success','UddoktaPay settings saved');
    }
}
