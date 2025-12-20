<?php

namespace App\Services\Settings;

use App\Models\Setting;

class SettingsService
{
    public function get(string $group, string $key, mixed $default = null): mixed
    {
        $row = Setting::query()->where('group', $group)->where('key', $key)->first();
        return $row?->value ?? $default;
    }

    public function set(string $group, string $key, mixed $value): void
    {
        Setting::query()->updateOrCreate(
            ['group'=>$group,'key'=>$key],
            ['value'=>$value]
        );
    }

    public function group(string $group): array
    {
        return Setting::query()->where('group', $group)->pluck('value','key')->toArray();
    }
}
