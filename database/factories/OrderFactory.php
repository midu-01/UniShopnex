<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 30, 400);
        $tax = round($subtotal * 0.05, 2);
        $shipping = 15;

        return [
            'user_id' => User::factory(),
            'address_id' => Address::factory(),
            'order_number' => 'USH-'.strtoupper(Str::random(10)),
            'status' => fake()->randomElement(['pending', 'processing', 'completed']),
            'payment_status' => 'paid',
            'subtotal_amount' => $subtotal,
            'tax_amount' => $tax,
            'shipping_amount' => $shipping,
            'discount_amount' => 0,
            'total_amount' => $subtotal + $tax + $shipping,
            'shipping_address' => ['city' => fake()->city()],
            'billing_address' => ['city' => fake()->city()],
            'placed_at' => now()->subDays(fake()->numberBetween(0, 10)),
        ];
    }
}
