<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceAdminController extends Controller
{
    public function edit(): Response
    {
        $row = Setting::query()->where('key','invoice.template')->first();
        return Inertia::render('Admin/Invoice/Edit', [
            'template' => $row?->value ?? [],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => ['required','string','max:255'],
            'company_address' => ['nullable','string'],
            'footer_note' => ['nullable','string'],
        ]);

        Setting::query()->updateOrCreate(
            ['key' => 'invoice.template'],
            ['group' => 'invoice', 'value' => $data]
        );

        return back()->with('success','Invoice template saved');
    }
}
