<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SmtpAdminController extends Controller
{
    public function edit(): Response
    {
        $row = Setting::query()->where('key','smtp')->first();
        return Inertia::render('Admin/Smtp/Edit', [
            'settings' => $row?->value ?? [],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mailer' => ['required','string'],
            'host' => ['required','string'],
            'port' => ['required','integer'],
            'username' => ['nullable','string'],
            'password' => ['nullable','string'],
            'encryption' => ['nullable','string'],
            'from_address' => ['required','email'],
            'from_name' => ['required','string'],
        ]);

        Setting::query()->updateOrCreate(
            ['key' => 'smtp'],
            ['group' => 'smtp', 'value' => $data]
        );

        return back()->with('success','SMTP settings saved');
    }
}
