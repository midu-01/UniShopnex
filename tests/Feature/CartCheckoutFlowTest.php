<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\SeedsRoles;
use Tests\TestCase;

class CartCheckoutFlowTest extends TestCase
{
    use RefreshDatabase;
    use SeedsRoles;

    public function test_customer_can_add_to_cart_and_checkout(): void
    {
        $this->seedRoles();

        $customer = User::factory()->create();
        $customer->assignRole('customer');
        $customer->cart()->create([
            'status' => 'active',
            'last_activity_at' => now(),
            'expires_at' => now()->addDay(),
        ]);

        $address = Address::factory()->create(['user_id' => $customer->id, 'is_default' => true]);

        $vendor = User::factory()->create();
        $vendor->assignRole('vendor');
        $store = $vendor->store()->create([
            'name' => 'Vendor Store',
            'slug' => 'vendor-store',
            'approval_status' => 'approved',
            'approved_at' => now(),
        ]);

        $product = Product::factory()->create([
            'store_id' => $store->id,
            'category_id' => Category::factory(),
        ]);

        $this->actingAs($customer)
            ->post(route('customer.cart.store'), [
                'product_id' => $product->id,
                'quantity' => 2,
            ])->assertRedirect(route('customer.cart.index'));

        $this->actingAs($customer)
            ->post(route('customer.checkout.store'), [
                'address_id' => $address->id,
                'provider' => 'manual',
            ])->assertRedirect();

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('order_items', ['product_id' => $product->id]);
    }
}
