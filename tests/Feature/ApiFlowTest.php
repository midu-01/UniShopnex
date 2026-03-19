<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\SeedsRoles;
use Tests\TestCase;

class ApiFlowTest extends TestCase
{
    use RefreshDatabase;
    use SeedsRoles;

    public function test_public_products_endpoint_returns_data(): void
    {
        $this->seedRoles();

        $vendor = User::factory()->create();
        $vendor->assignRole('vendor');
        $store = $vendor->store()->create([
            'name' => 'Vendor Store',
            'slug' => 'vendor-store',
            'approval_status' => 'approved',
            'approved_at' => now(),
        ]);

        Product::factory()->create([
            'store_id' => $store->id,
            'category_id' => Category::factory(),
        ]);

        $this->getJson('/api/products')
            ->assertOk()
            ->assertJsonStructure(['data']);
    }
}
