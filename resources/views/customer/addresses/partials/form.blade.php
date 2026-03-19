<x-ui.card>
    <form method="POST" action="{{ $action }}" class="grid gap-5 md:grid-cols-2">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif
        <x-ui.select name="type" label="Type">
            <option value="shipping" @selected(old('type', $address?->type) === 'shipping')>Shipping</option>
            <option value="billing" @selected(old('type', $address?->type) === 'billing')>Billing</option>
        </x-ui.select>
        <x-ui.input name="label" label="Label" :value="$address?->label" />
        <x-ui.input name="full_name" label="Full name" :value="$address?->full_name" />
        <x-ui.input name="phone" label="Phone" :value="$address?->phone" />
        <div class="md:col-span-2">
            <x-ui.input name="line_1" label="Address line 1" :value="$address?->line_1" />
        </div>
        <div class="md:col-span-2">
            <x-ui.input name="line_2" label="Address line 2" :value="$address?->line_2" />
        </div>
        <x-ui.input name="city" label="City" :value="$address?->city" />
        <x-ui.input name="state" label="State" :value="$address?->state" />
        <x-ui.input name="postal_code" label="Postal code" :value="$address?->postal_code" />
        <x-ui.input name="country" label="Country" :value="$address?->country" />
        <label class="flex items-center gap-3 md:col-span-2">
            <input type="checkbox" name="is_default" value="1" class="h-4 w-4 rounded border-slate-300" @checked(old('is_default', $address?->is_default))>
            <span class="text-sm text-slate-600 dark:text-slate-300">Mark as default</span>
        </label>
        <div class="md:col-span-2">
            <x-ui.button type="submit">Save address</x-ui.button>
        </div>
    </form>
</x-ui.card>
