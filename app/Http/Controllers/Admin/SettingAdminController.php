<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class SettingAdminController extends Controller
{
    public function edit(): Response
    {
        $rows = Setting::query()->where('group','general')->get();
        $map = [];
        foreach ($rows as $r) {
            $map[$r->key] = $r->value;
        }

        return Inertia::render('Admin/Settings/Edit', [
            'settings' => $map,
            'timezones' => \DateTimeZone::listIdentifiers(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $timezones = \DateTimeZone::listIdentifiers();

        $data = $request->validate([
            'site_name' => ['required','string','max:255'],
            'default_currency' => ['required','in:USD,BDT'],
            'exchange_rate_usd_to_bdt' => ['required','numeric','min:0'],
            'languages' => ['required','array','min:1'],
            'languages.*' => ['in:en,bn'],
            'timezone' => ['required', Rule::in($timezones)],
            'site_logo' => ['nullable','image','max:4096'],
            'site_logo_wide' => ['nullable','image','max:4096'],
        ]);

        Setting::query()->updateOrCreate(['key' => 'site_name'], ['group'=>'general','value'=>$data['site_name']]);
        Setting::query()->updateOrCreate(['key' => 'default_currency'], ['group'=>'general','value'=>$data['default_currency']]);
        Setting::query()->updateOrCreate(['key' => 'exchange_rate_usd_to_bdt'], ['group'=>'general','value'=>$data['exchange_rate_usd_to_bdt']]);
        Setting::query()->updateOrCreate(['key' => 'languages'], ['group'=>'general','value'=>$data['languages']]);
        Setting::query()->updateOrCreate(['key' => 'timezone'], ['group'=>'general','value'=>$data['timezone']]);

        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            $existing = Setting::query()->where('key', 'site_logo')->first();
            if ($existing?->value) {
                Storage::disk('public')->delete($existing->value);
            }
            Setting::query()->updateOrCreate(['key' => 'site_logo'], ['group'=>'general','value'=>$logoPath]);
        }

        if ($request->hasFile('site_logo_wide')) {
            $logoWidePath = $request->file('site_logo_wide')->store('settings', 'public');
            $existingWide = Setting::query()->where('key', 'site_logo_wide')->first();
            if ($existingWide?->value) {
                Storage::disk('public')->delete($existingWide->value);
            }
            Setting::query()->updateOrCreate(['key' => 'site_logo_wide'], ['group'=>'general','value'=>$logoWidePath]);
        }

        return back()->with('success','Settings saved');
    }
}
