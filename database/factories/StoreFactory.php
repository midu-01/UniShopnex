<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StoreFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->company();

        return [
            'user_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->unique()->numberBetween(1, 9999)),
            'email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'description' => fake()->paragraph(),
            'address_line' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->country(),
            'approval_status' => 'approved',
            'is_active' => true,
            'settings' => ['currency' => 'USD'],
            'meta' => ['tagline' => fake()->sentence(3)],
            'approved_at' => now(),
        ];
    }
}
