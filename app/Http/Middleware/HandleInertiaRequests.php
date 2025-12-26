<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     */
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $siteSettings = Setting::query()
            ->where('group', 'general')
            ->whereIn('key', ['site_name', 'site_logo', 'site_logo_wide'])
            ->pluck('value', 'key')
            ->toArray();

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'site' => [
                'name' => $siteSettings['site_name'] ?? null,
                'logo' => $siteSettings['site_logo'] ?? null,
                'logo_wide' => $siteSettings['site_logo_wide'] ?? null,
            ],
            'i18n' => [
                'locale' => app()->getLocale(),
                'admin' => trans('admin'),
            ],
            'csrf_token' => csrf_token(),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ]);
    }
}
