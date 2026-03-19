<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'provider' => 'manual',
            'transaction_id' => 'TXN-'.strtoupper(Str::random(12)),
            'amount' => fake()->randomFloat(2, 20, 400),
            'currency' => 'USD',
            'status' => 'paid',
            'payload' => ['reference' => Str::random(8)],
            'paid_at' => now(),
        ];
    }
}
