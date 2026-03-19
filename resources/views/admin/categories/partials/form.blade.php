<x-ui.card>
    <form method="POST" action="{{ $action }}" class="grid gap-5 md:grid-cols-2">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif
        <x-ui.input name="name" label="Name" :value="$category->name" />
        <x-ui.input name="sort_order" label="Sort order" type="number" :value="$category->sort_order" />
        <x-ui.select name="parent_id" label="Parent category">
            <option value="">None</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
            @endforeach
        </x-ui.select>
        <div></div>
        <div class="md:col-span-2">
            <x-ui.textarea name="description" label="Description" :value="$category->description" />
        </div>
        <label class="flex items-center gap-3">
            <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-slate-300" @checked(old('is_active', $category->is_active ?? true))>
            <span class="text-sm text-slate-600 dark:text-slate-300">Active</span>
        </label>
        <label class="flex items-center gap-3">
            <input type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded border-slate-300" @checked(old('is_featured', $category->is_featured))>
            <span class="text-sm text-slate-600 dark:text-slate-300">Featured</span>
        </label>
        <div class="md:col-span-2">
            <x-ui.button type="submit">Save category</x-ui.button>
        </div>
    </form>
</x-ui.card>
