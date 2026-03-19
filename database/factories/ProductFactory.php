<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = Str::title(fake()->words(3, true));
        $price = fake()->randomFloat(2, 10, 500);

        return [
            'store_id' => Store::factory(),
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->unique()->numberBetween(1, 9999)),
            'sku' => strtoupper(fake()->bothify('SKU-####??')),
            'status' => 'published',
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraphs(2, true),
            'price' => $price,
            'compare_price' => $price + fake()->randomFloat(2, 5, 50),
            'cost_price' => max(1, $price - fake()->randomFloat(2, 1, 20)),
            'stock_quantity' => fake()->numberBetween(5, 120),
            'low_stock_threshold' => fake()->numberBetween(3, 10),
            'is_featured' => fake()->boolean(35),
            'is_published' => true,
            'meta' => ['brand' => fake()->company()],
            'published_at' => now(),
        ];
    }
}
