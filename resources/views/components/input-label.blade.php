@props(['value', 'astrik' => false])

<label {{ $attributes->merge(['class' => 'block font-medium leading-6 text-gray-800 mb-1 text-sm']) }}>
    {{ $value ?? $slot }}
    @if ($astrik)
        <sup class="text-red-500">*</sup>
    @endif
</label>
