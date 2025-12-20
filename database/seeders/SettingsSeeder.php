<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(['group'=>'payment_uddoktapay','key'=>'mode'], ['value'=>'sandbox']);
        Setting::updateOrCreate(['group'=>'payment_uddoktapay','key'=>'sandbox_base_url'], ['value'=>'https://sandbox.uddoktapay.com']);
        Setting::updateOrCreate(['group'=>'payment_uddoktapay','key'=>'live_base_url'], ['value'=>'https://pay.uddoktapaybd.com']);
        Setting::updateOrCreate(['group'=>'payment_uddoktapay','key'=>'api_key'], ['value'=>'']);
        Setting::updateOrCreate(['group'=>'payment_uddoktapay','key'=>'redirect_url'], ['value'=>config('app.url')]);
        Setting::updateOrCreate(['group'=>'payment_uddoktapay','key'=>'cancel_url'], ['value'=>config('app.url')]);

        Setting::updateOrCreate(['group'=>'currency','key'=>'exchange_rate_usd_to_bdt'], ['value'=>110.00]);
        Setting::updateOrCreate(['group'=>'app','key'=>'default_language'], ['value'=>'bn']);
    }
}
