<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Setting;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedRolesAndPermissions();
        $this->seedPlatformSettings();

        $admin = User::query()->create([
            'name' => 'Platform Admin',
            'email' => 'admin@unishopnex.test',
            'phone' => '+8801000000000',
            'headline' => 'Platform supervisor',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $categories = collect([
            'Electronics',
            'Fashion',
            'Home Decor',
            'Books',
            'Beauty',
            'Sports',
        ])->map(fn (string $name, int $index) => Category::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'sort_order' => $index,
            'is_featured' => true,
        ]));

        $vendors = User::factory(3)->create()->each(function (User $vendor, int $index): void {
            $vendor->update([
                'email' => 'vendor'.($index + 1).'@unishopnex.test',
            ]);
            $vendor->assignRole('vendor');
            $vendor->store()->create([
                'name' => 'Vendor '.($index + 1).' Store',
                'slug' => 'vendor-'.($index + 1).'-store',
                'email' => 'vendor'.($index + 1).'@unishopnex.test',
                'approval_status' => 'approved',
                'approved_at' => now(),
            ]);
        });

        $customers = User::factory(5)->create()->each(function (User $customer, int $index): void {
            $customer->update([
                'email' => 'customer'.($index + 1).'@unishopnex.test',
            ]);
            $customer->assignRole('customer');
            $customer->cart()->create([
                'status' => 'active',
                'last_activity_at' => now(),
                'expires_at' => now()->addDays(7),
            ]);
            Address::factory()->create([
                'user_id' => $customer->id,
                'full_name' => $customer->name,
                'is_default' => true,
            ]);
        });

        $vendors->each(function (User $vendor) use ($categories): void {
            Product::factory(8)->create([
                'store_id' => $vendor->store->id,
                'category_id' => $categories->random()->id,
            ])->each(function (Product $product): void {
                ProductImage::factory()->create([
                    'product_id' => $product->id,
                    'alt_text' => $product->name,
                ]);
            });
        });

        $customers->take(3)->each(function (User $customer) use ($vendors): void {
            $address = $customer->addresses()->first();
            $products = Product::query()->inRandomOrder()->limit(2)->get();

            $order = Order::factory()->create([
                'user_id' => $customer->id,
                'address_id' => $address?->id,
            ]);

            foreach ($products as $product) {
                $order->items()->create([
                    'store_id' => $product->store_id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'quantity' => 1,
                    'unit_price' => $product->price,
                    'total_price' => $product->price,
                ]);
            }

            $order->payment()->create([
                'provider' => 'manual',
                'transaction_id' => 'TXN-'.strtoupper(Str::random(12)),
                'amount' => $order->total_amount,
                'currency' => 'USD',
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        });
    }

    protected function seedRolesAndPermissions(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        collect([
            'manage platform',
            'manage users',
            'manage vendors',
            'manage categories',
            'manage products',
            'manage orders',
            'manage settings',
            'manage own store',
            'manage own products',
            'manage own orders',
            'shop',
        ])->each(fn (string $name) => Permission::findOrCreate($name, 'web'));

        Role::findOrCreate('admin', 'web')->givePermissionTo(Permission::all());
        Role::findOrCreate('vendor', 'web')->givePermissionTo([
            'manage own store',
            'manage own products',
            'manage own orders',
        ]);
        Role::findOrCreate('customer', 'web')->givePermissionTo(['shop']);
    }

    protected function seedPlatformSettings(): void
    {
        collect([
            'store_name' => 'UniShopnex',
            'support_email' => 'support@unishopnex.test',
            'currency' => 'USD',
            'homepage_hero' => 'Launch, scale, and learn Laravel with one serious product.',
        ])->each(function (string $value, string $key): void {
            Setting::query()->updateOrCreate(
                ['key' => $key],
                [
                    'group' => 'platform',
                    'label' => Str::headline($key),
                    'type' => 'text',
                    'value' => $value,
                ]
            );
        });
    }
}
