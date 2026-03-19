<?php

namespace App\Http\Controllers\Vendor;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\StoreProductRequest;
use App\Http\Requests\Vendor\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductRepositoryInterface $products,
    ) {
    }

    public function index(Request $request): View
    {
        return view('vendor.products.index', [
            'products' => $this->products->paginateForVendor($request->user()),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Product::class);

        return view('vendor.products.create', [
            'categories' => Category::query()->where('is_active', true)->orderBy('name')->get(),
            'product' => new Product(),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        $data = $request->validated();
        $data['store_id'] = $request->user()->store->id;
        $data['slug'] = Str::slug($request->string('name').'-'.Str::random(5));
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $request->boolean('is_published') ? now() : null;

        $product = Product::query()->create($data);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->images()->create([
                'path' => $path,
                'alt_text' => $product->name,
                'sort_order' => 0,
                'is_primary' => true,
            ]);
        }

        return Redirect::route('vendor.products.index')->with('status', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        return view('vendor.products.edit', [
            'categories' => Category::query()->where('is_active', true)->orderBy('name')->get(),
            'product' => $product->load('primaryImage'),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $data = $request->validated();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $request->boolean('is_published') ? ($product->published_at ?? now()) : null;

        $product->update($data);

        if ($request->hasFile('image')) {
            $product->images()->update(['is_primary' => false]);
            $path = $request->file('image')->store('products', 'public');
            $product->images()->create([
                'path' => $path,
                'alt_text' => $product->name,
                'sort_order' => 0,
                'is_primary' => true,
            ]);
        }

        return Redirect::route('vendor.products.index')->with('status', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);
        $product->delete();

        return Redirect::route('vendor.products.index')->with('status', 'Product deleted.');
    }
}
