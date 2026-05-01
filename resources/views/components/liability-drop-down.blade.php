@props(['liabilityRange'])
@php
$lr=request('lr');
$selectedText='All';
foreach ($liabilityRange as $index => $range) {
if ($lr == $index) {
$selectedText = "Liability Range : {$range}";
break;
}
}
@endphp

<div x-data="{ open: false,liabilityNestedOpen: false, selected: '{{ str_replace("'", "\\'", $selectedText) }}' }" class="relative w-64">
    <!-- Trigger Button -->
    <button
        @click="open = !open"
        class="w-full text-left bg-white border border-slate-400 ring-1 ring-slate-400 focus:ring-orange-600 focus:outline-none rounded-md text-sm px-4 py-2">
        <span x-text="selected"></span>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" @click.away="open = false" x-cloak class="absolute z-10 mt-1 w-full bg-white border border-slate-300 rounded-md shadow-lg">
        <ul class="py-1 text-sm text-slate-700">
            <li>
                <a
                    href="{{ route(auth()->user()->roleName . 'liability.index') }}"
                    @click="selected = '{{ $range }}'; open = false; nestedOpen = false"
                    class="block px-4 py-2 hover:bg-slate-100">
                    {{ __('All') }}
                </a>
            </li>
            <li @mouseenter="liabilityNestedOpen = true" @mouseleave="liabilityNestedOpen = false" class="relative">
                <div class="flex justify-between items-center px-4 py-2 hover:bg-slate-100 cursor-pointer">
                    {{ __('Liabilities') }}
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <!-- Nested submenu -->
                <div x-show="liabilityNestedOpen" x-cloak class="absolute left-full top-0 w-48 h-48 bg-white border border-slate-300 rounded-md shadow-lg overflow-y-auto">
                    <ul class="py-2">
                        <li class="block px-4 py-2 text-center border-b border-slate-200 text-md font-semibold">Select Range</li>
                        @foreach ($liabilityRange as $index => $range)
                        <li>
                            <a
                                href="{{ route(auth()->user()->roleName . 'liability.index', ['lr' => $index]) }}"
                                @click="selected = '{{ $range }}'; open = false; nestedOpen = false"
                                class="block px-4 py-2 hover:bg-slate-100 text-center">
                                {{ $range }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>