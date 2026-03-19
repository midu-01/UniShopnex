<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => fake()->randomElement(['shipping', 'billing']),
            'label' => fake()->randomElement(['Home', 'Office']),
            'full_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'line_1' => fake()->streetAddress(),
            'line_2' => fake()->secondaryAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->country(),
            'is_default' => false,
        ];
    }
}
