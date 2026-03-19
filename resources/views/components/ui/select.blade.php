@props(['label' => null, 'name'])

<label class="block">
    @if ($label)
        <span class="label">{{ $label }}</span>
    @endif
    <select name="{{ $name }}" {{ $attributes->merge(['class' => 'input']) }}>
        {{ $slot }}
    </select>
    @error($name)
        <span class="mt-2 block text-sm text-rose-500">{{ $message }}</span>
    @enderror
</label>
