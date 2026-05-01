@props(['colspan' => null, 'class' => null])
@php
    if ($colspan) {
        $class .= 'text-center';
    }
@endphp
<td class="whitespace-nowrap px-2 py-2.5 text-sm text-gray-800 {{ $class }} {{ $colspan ? 'text-center' : '' }}"
    colspan="{{ $colspan }}">
    {{ $slot }}
</td>
