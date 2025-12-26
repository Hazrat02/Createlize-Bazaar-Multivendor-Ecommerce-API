<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'og_image' => ['nullable','image','max:4096'],
        ]);

        $payload = [
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keywords' => $data['meta_keywords'] ?? null,
        ];

        $row = Setting::query()->where('key','seo')->first();
        $existing = $row?->value ?? [];
        if (isset($existing['og_image'])) {
            $payload['og_image'] = $existing['og_image'];
        }

        if ($request->hasFile('og_image')) {
            $path = $request->file('og_image')->store('settings', 'public');
            if (!empty($existing['og_image'])) {
                Storage::disk('public')->delete($existing['og_image']);
            }
            $payload['og_image'] = $path;
        }

        Setting::query()->updateOrCreate(
            ['key' => 'seo'],
            ['group' => 'seo', 'value' => $payload]
        );

        return back()->with('success','SEO settings saved');
    }
}
