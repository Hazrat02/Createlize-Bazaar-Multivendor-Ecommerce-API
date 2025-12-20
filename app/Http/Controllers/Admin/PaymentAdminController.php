<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PaymentAdminController extends Controller
{
    public function edit(): Response
    {
        $row = Setting::query()->where('key','payment.uddoktapay')->first();
        return Inertia::render('Admin/Payments/UddoktaPay', [
            'settings' => $row?->value ?? [],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mode' => ['required','in:sandbox,live'],
            'sandbox_base_url' => ['nullable','string'],
            'sandbox_api_key' => ['nullable','string'],
            'sandbox_secret' => ['nullable','string'],
            'live_base_url' => ['nullable','string'],
            'live_api_key' => ['nullable','string'],
            'live_secret' => ['nullable','string'],
        ]);

        Setting::query()->updateOrCreate(
            ['key' => 'payment.uddoktapay'],
            ['group' => 'payment', 'value' => $data]
        );

        return back()->with('success','UddoktaPay settings saved');
    }
}
