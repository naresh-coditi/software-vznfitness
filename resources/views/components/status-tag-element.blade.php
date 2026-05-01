@props(['label' => null, 'color' => null])
<p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal opacity-70">
    <span
        class="relative inline-grid items-center font-sans font-bold uppercase whitespace-nowrap select-none {{ $color }} py-1 px-2 text-xs rounded-md">
        {{ $label }}
    </span>
</p>
