<th {{ $attributes->merge([
    'class' => 'px-2 py-4 text-left text-sm font-semibold text-gray-900',
]) }}>
    <span class="antialiased font-sans text-sm font-medium text-gray-600 leading-none text-center">
        {{ $slot }}
    </span>
</th>
