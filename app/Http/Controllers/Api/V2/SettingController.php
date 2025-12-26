<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    public function general()
    {
        $settings = Setting::query()
            ->where('group', 'general')
            ->whereIn('key', ['site_name', 'site_logo', 'site_logo_wide'])
            ->pluck('value', 'key');

        $logoPath = $settings['site_logo'] ?? null;
        $logoWidePath = $settings['site_logo_wide'] ?? null;
        $googleEnabled = Setting::query()
            ->where('group', 'auth_google')
            ->where('key', 'enabled')
            ->value('value');

        return response()->json([
            'site_name' => $settings['site_name'] ?? config('app.name'),
            'site_logo_url' => $logoPath ? asset('storage/' . $logoPath) : null,
            'site_logo_wide_url' => $logoWidePath ? asset('storage/' . $logoWidePath) : null,
            'auth_google_enabled' => (bool)$googleEnabled,
        ]);
    }
}
