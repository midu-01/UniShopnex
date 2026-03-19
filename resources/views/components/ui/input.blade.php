@props(['label' => null, 'name', 'value' => null, 'type' => 'text'])

<label class="block">
    @if ($label)
        <span class="label">{{ $label }}</span>
    @endif
    <input name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}" {{ $attributes->merge(['class' => 'input']) }}>
    @error($name)
        <span class="mt-2 block text-sm text-rose-500">{{ $message }}</span>
    @enderror
</label>
