<?php

namespace Database\Factories;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'event' => fake()->randomElement(['auth.login', 'product.created', 'order.placed']),
            'description' => fake()->sentence(),
            'properties' => ['source' => 'factory'],
            'ip_address' => fake()->ipv4(),
        ];
    }
}
