<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'path' => 'products/placeholders/product-'.fake()->numberBetween(1, 6).'.png',
            'alt_text' => fake()->words(3, true),
            'sort_order' => 0,
            'is_primary' => true,
        ];
    }
}
