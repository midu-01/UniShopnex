<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Collection;

class SettingService
{
    public function allGrouped(): Collection
    {
        return Setting::query()->orderBy('group')->orderBy('key')->get()->groupBy('group');
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Setting::query()->where('key', $key)->value('value') ?? $default;
    }

    public function setMany(string $group, array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(
                ['key' => $key],
                [
                    'group' => $group,
                    'label' => str($key)->headline()->toString(),
                    'type' => 'text',
                    'value' => $value,
                ]
            );
        }
    }
}
