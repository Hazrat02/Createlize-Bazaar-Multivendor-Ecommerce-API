<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required','string','max:255'],
            'default_currency' => ['required','in:USD,BDT'],
            'exchange_rate_usd_to_bdt' => ['required','numeric','min:0'],
            'languages' => ['required','array'],
        ]);

        Setting::query()->updateOrCreate(['key' => 'site_name'], ['group'=>'general','value'=>$data['site_name']]);
        Setting::query()->updateOrCreate(['key' => 'default_currency'], ['group'=>'general','value'=>$data['default_currency']]);
        Setting::query()->updateOrCreate(['key' => 'exchange_rate_usd_to_bdt'], ['group'=>'general','value'=>$data['exchange_rate_usd_to_bdt']]);
        Setting::query()->updateOrCreate(['key' => 'languages'], ['group'=>'general','value'=>$data['languages']]);

        return back()->with('success','Settings saved');
    }
}
