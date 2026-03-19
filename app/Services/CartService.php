<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;

class CartService
{
    public function current(User $user): Cart
    {
        return Cart::query()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'status' => 'active',
                'last_activity_at' => now(),
                'expires_at' => now()->addDays(7),
            ]
        )->loadMissing('items.product.primaryImage');
    }

    public function add(User $user, Product $product, int $quantity = 1): Cart
    {
        $cart = $this->current($user);
        $existingQuantity = (int) ($cart->items()->where('product_id', $product->id)->value('quantity') ?? 0);

        $cart->items()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'quantity' => max(1, $existingQuantity + $quantity),
                'unit_price' => $product->price,
            ]
        );

        $cart->update([
            'last_activity_at' => now(),
            'expires_at' => now()->addDays(7),
        ]);

        return $this->current($user);
    }

    public function updateQuantity(User $user, Product $product, int $quantity): Cart
    {
        $cart = $this->current($user);

        if ($quantity <= 0) {
            $cart->items()->where('product_id', $product->id)->delete();
        } else {
            $cart->items()->where('product_id', $product->id)->update([
                'quantity' => $quantity,
                'unit_price' => $product->price,
            ]);
        }

        $cart->update(['last_activity_at' => now()]);

        return $this->current($user);
    }

    public function clear(User $user): void
    {
        $this->current($user)->items()->delete();
    }

    public function totals(Cart $cart): array
    {
        $subtotal = $cart->items->sum(fn ($item) => $item->quantity * $item->unit_price);
        $tax = round($subtotal * 0.05, 2);
        $shipping = $subtotal > 200 ? 0 : 15;

        return [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'discount' => 0,
            'total' => max(0, $subtotal + $tax + $shipping),
            'count' => $cart->items->sum('quantity'),
        ];
    }

    public function itemSummary(User $user): Collection
    {
        return $this->current($user)->items;
    }
}
