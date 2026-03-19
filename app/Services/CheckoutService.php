<?php

namespace App\Services;

use App\Events\OrderPlaced;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService
{
    public function __construct(
        protected CartService $cartService,
        protected ActivityLogService $activityLog,
    ) {
    }

    public function placeOrder(User $user, Address $address, array $payload = []): Order
    {
        $cart = $this->cartService->current($user);
        $cart->loadMissing('items.product.store');

        abort_if($cart->items->isEmpty(), 422, 'Your cart is empty.');

        return DB::transaction(function () use ($user, $address, $cart, $payload): Order {
            $totals = $this->cartService->totals($cart);

            $order = Order::query()->create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'order_number' => 'USH-'.strtoupper(Str::random(10)),
                'status' => 'pending',
                'payment_status' => 'paid',
                'subtotal_amount' => $totals['subtotal'],
                'tax_amount' => $totals['tax'],
                'shipping_amount' => $totals['shipping'],
                'discount_amount' => $totals['discount'],
                'total_amount' => $totals['total'],
                'notes' => $payload['notes'] ?? null,
                'placed_at' => now(),
                'shipping_address' => $address->toSnapshot(),
                'billing_address' => $address->toSnapshot(),
            ]);

            foreach ($cart->items as $item) {
                /** @var Product $product */
                $product = $item->product;

                $order->items()->create([
                    'store_id' => $product->store_id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->quantity * $item->unit_price,
                ]);

                $product->decrement('stock_quantity', $item->quantity);
            }

            $order->payment()->create([
                'provider' => $payload['provider'] ?? 'manual',
                'transaction_id' => 'TXN-'.strtoupper(Str::random(12)),
                'amount' => $order->total_amount,
                'currency' => 'USD',
                'status' => 'paid',
                'paid_at' => now(),
                'payload' => $payload,
            ]);

            $cart->update([
                'status' => 'converted',
                'converted_at' => now(),
            ]);
            $cart->items()->delete();

            $this->activityLog->log(
                user: $user,
                event: 'order.placed',
                description: 'Placed order '.$order->order_number,
                subject: $order,
            );

            OrderPlaced::dispatch($order);

            return $order->load(['items.product.primaryImage', 'payment', 'user']);
        });
    }
}
