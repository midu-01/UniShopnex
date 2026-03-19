<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Storefront\HomeController;
use App\Http\Controllers\Storefront\ProductCatalogController;
use App\Http\Controllers\Storefront\ProductController;
use App\Http\Controllers\Storefront\StoreController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Vendor\OrderController as VendorOrderController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use App\Http\Controllers\Vendor\StoreController as VendorStoreController;
use App\Support\DashboardRedirector;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductCatalogController::class, 'index'])->name('products.index');
Route::get('/products/{productSlug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/stores/{store:slug}', [StoreController::class, 'show'])->name('stores.show');

Route::get('/dashboard', function (DashboardRedirector $redirector) {
    return redirect()->to($redirector->routeFor(auth()->user()));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('customer')
    ->as('customer.')
    ->middleware(['auth', 'verified', 'role:customer'])
    ->group(function (): void {
        Route::get('/dashboard', CustomerDashboardController::class)->name('dashboard');
        Route::resource('addresses', AddressController::class)->except(['show']);
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/items', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/items/{product}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/items/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
        Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    });

Route::prefix('vendor')
    ->as('vendor.')
    ->middleware(['auth', 'verified', 'role:vendor'])
    ->group(function (): void {
        Route::get('/dashboard', VendorDashboardController::class)->name('dashboard');
        Route::get('/store', [VendorStoreController::class, 'edit'])->name('store.edit');
        Route::patch('/store', [VendorStoreController::class, 'update'])->name('store.update');
        Route::resource('products', VendorProductController::class)->except(['show']);
        Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [VendorOrderController::class, 'show'])->name('orders.show');
    });

Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function (): void {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::get('/vendors', [AdminVendorController::class, 'index'])->name('vendors.index');
        Route::patch('/vendors/{store}', [AdminVendorController::class, 'update'])->name('vendors.update');
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
        Route::get('/settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::patch('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });

require __DIR__.'/auth.php';
