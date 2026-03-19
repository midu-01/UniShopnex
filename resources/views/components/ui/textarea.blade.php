@props(['label' => null, 'name', 'value' => null, 'rows' => 4])

<label class="block">
    @if ($label)
        <span class="label">{{ $label }}</span>
    @endif
    <textarea name="{{ $name }}" rows="{{ $rows }}" {{ $attributes->merge(['class' => 'input']) }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <span class="mt-2 block text-sm text-rose-500">{{ $message }}</span>
    @enderror
</label>
