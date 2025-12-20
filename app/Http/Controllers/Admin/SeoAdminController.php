<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SeoAdminController extends Controller
{
    public function edit(): Response
    {
        $row = Setting::query()->where('key','seo')->first();
        return Inertia::render('Admin/Seo/Edit', [
            'seo' => $row?->value ?? [],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'meta_title' => ['nullable','string','max:255'],
            'meta_description' => ['nullable','string','max:500'],
            'meta_keywords' => ['nullable','string','max:500'],
        ]);

        Setting::query()->updateOrCreate(
            ['key' => 'seo'],
            ['group' => 'seo', 'value' => $data]
        );

        return back()->with('success','SEO settings saved');
    }
}
