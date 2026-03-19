<x-ui.card>
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="grid gap-5 md:grid-cols-2">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif
        <x-ui.input name="name" label="Product name" :value="$product->name" />
        <x-ui.input name="sku" label="SKU" :value="$product->sku" />
        <x-ui.select name="category_id" label="Category">
            <option value="">Select category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </x-ui.select>
        <x-ui.select name="status" label="Status">
            @foreach (['draft', 'published', 'archived'] as $status)
                <option value="{{ $status }}" @selected(old('status', $product->status ?: 'draft') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </x-ui.select>
        <x-ui.input name="price" label="Price" type="number" step="0.01" :value="$product->price" />
        <x-ui.input name="compare_price" label="Compare price" type="number" step="0.01" :value="$product->compare_price" />
        <x-ui.input name="cost_price" label="Cost price" type="number" step="0.01" :value="$product->cost_price" />
        <x-ui.input name="stock_quantity" label="Stock quantity" type="number" :value="$product->stock_quantity" />
        <x-ui.input name="low_stock_threshold" label="Low stock threshold" type="number" :value="$product->low_stock_threshold ?: 5" />
        <label class="block">
            <span class="label">Featured image</span>
            <input class="input" type="file" name="image">
        </label>
        <div class="md:col-span-2">
            <x-ui.input name="short_description" label="Short description" :value="$product->short_description" />
        </div>
        <div class="md:col-span-2">
            <x-ui.textarea name="description" label="Description" :value="$product->description" rows="6" />
        </div>
        <label class="flex items-center gap-3">
            <input type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded border-slate-300" @checked(old('is_featured', $product->is_featured))>
            <span class="text-sm text-slate-600 dark:text-slate-300">Featured product</span>
        </label>
        <label class="flex items-center gap-3">
            <input type="checkbox" name="is_published" value="1" class="h-4 w-4 rounded border-slate-300" @checked(old('is_published', $product->is_published))>
            <span class="text-sm text-slate-600 dark:text-slate-300">Publish to storefront</span>
        </label>
        <div class="md:col-span-2">
            <x-ui.button type="submit">Save product</x-ui.button>
        </div>
    </form>
</x-ui.card>
