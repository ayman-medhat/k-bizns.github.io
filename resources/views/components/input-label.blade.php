@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#5e4a36]']) }}>
    {{ $value ?? $slot }}
</label>