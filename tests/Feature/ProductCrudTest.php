<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\SeedsRoles;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;
    use SeedsRoles;

    public function test_vendor_can_create_a_product(): void
    {
        $this->seedRoles();

        $vendor = User::factory()->create();
        $vendor->assignRole('vendor');
        $vendor->store()->create([
            'name' => 'Vendor Store',
            'slug' => 'vendor-store',
            'approval_status' => 'approved',
            'approved_at' => now(),
        ]);

        $category = Category::factory()->create();

        $response = $this->actingAs($vendor)->post(route('vendor.products.store'), [
            'category_id' => $category->id,
            'name' => 'Demo Product',
            'sku' => 'SKU-TEST-1',
            'status' => 'published',
            'price' => 120,
            'compare_price' => 150,
            'cost_price' => 90,
            'stock_quantity' => 25,
            'low_stock_threshold' => 5,
            'is_published' => 1,
        ]);

        $response->assertRedirect(route('vendor.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Demo Product']);
    }
}
