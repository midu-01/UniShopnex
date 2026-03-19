<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'group' => 'platform',
            'key' => 'setting_'.fake()->unique()->word(),
            'label' => fake()->words(2, true),
            'type' => 'text',
            'value' => ['content' => fake()->sentence()],
            'is_public' => false,
        ];
    }
}
