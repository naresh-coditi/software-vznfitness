@props(['plans','liabilityRange'])
@php
$orderby = request('orderby');
$mp=request('mp');
$lr=request('lr');
$selectedText = match($orderby) {
'1' => __('Remaining Balance'),
'2' => 'All Memberships',
'3' => 'Expired Plan',
default => 'All'
};
foreach ($plans as $index => $plan) {
if ($mp == $plan) {
$selectedText = $plan;
break;
}
#foreach ($liabilityRange as $index => $range) {
#if ($lr == $index) {
#$selectedText = 'Liability Range : '.$range;
#break;
#}
#}
}
@endphp

<div x-data="{ open: false, nestedOpen: false,liabilityNestedOpen: false, selected: '{{ str_replace("'", "\\'", $selectedText) }}' }" class="relative w-64">
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
                    href="{{ route(auth()->user()->roleName . 'user.index') }}"
                    @click="selected = 'All'; open = false"
                    class="block px-4 py-2 hover:bg-slate-100">
                    All
                </a>
            </li>
            <li>
                <a
                    href="{{ route(auth()->user()->roleName . 'user.index', ['orderby' => 1]) }}"
                    @click="selected = '{{ __('Remaining Balance') }}'; open = false"
                    class="block px-4 py-2 hover:bg-slate-100">
                    {{ __('Remaining Balance') }}
                </a>
            </li>
            <!-- <li>
                <a 
                    href="{{ route(auth()->user()->roleName . 'user.index', ['orderby' => 3]) }}" 
                    @click="selected = '{{ __('Remaining Balance') }}'; open = false"
                    class="block px-4 py-2 hover:bg-slate-100">
                    {{ __('Expired Plan') }}
                </a>
            </li> -->
            <li @mouseenter="nestedOpen = true" @mouseleave="nestedOpen = false" class="relative">
                <div class="flex justify-between items-center px-4 py-2 hover:bg-slate-100 cursor-pointer">
                    {{ __('Membership') }}
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <!-- Nested submenu -->
                <div x-show="nestedOpen" x-cloak class="absolute left-full top-0 w-64 h-64 bg-white border border-slate-300 rounded-md shadow-lg overflow-y-auto">
                    <ul class="py-2">
                        <li>
                            <a
                                href="{{ route(auth()->user()->roleName . 'user.index', ['orderby' => 2]) }}"
                                @click="selected = '{{ __('All Memberships') }}'; open = false; nestedOpen = false"
                                class="block px-4 py-2 hover:bg-slate-100 text-center border-b border-slate-200">
                                {{ __('All Memberships') }}
                            </a>
                        </li>
                        @foreach ($plans as $index => $plan)
                        <li>
                            <a
                                href="{{ route(auth()->user()->roleName . 'user.index', ['orderby' => 4, 'mp' => $plan]) }}"
                                @click="selected = '{{ $plan }}'; open = false; nestedOpen = false"
                                class="block px-4 py-2 hover:bg-slate-100 text-center">
                                {{ $plan }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            {{--  <li @mouseenter="liabilityNestedOpen = true" @mouseleave="liabilityNestedOpen = false" class="relative">
                <div class="flex justify-between items-center px-4 py-2 hover:bg-slate-100 cursor-pointer">
                    {{ __('Liabilities') }}
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <!-- Nested submenu -->
                <div x-show="liabilityNestedOpen" x-cloak class="absolute left-full top-0 w-44 h-44 bg-white border border-slate-300 rounded-md shadow-lg overflow-y-auto">
                    <ul class="py-2">
                        <li class="block px-4 py-2 text-center border-b border-slate-200 text-md font-semibold">Select Range</li>
                        @foreach ($liabilityRange as $index => $range)
                        <li>
                            <a
                                href="{{ route(auth()->user()->roleName . 'user.index', ['orderby' => 4, 'lr' => $index]) }}"
                                @click="selected = '{{ $range }}'; open = false; nestedOpen = false"
                                class="block px-4 py-2 hover:bg-slate-100 text-center">
                                {{ $range }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </li>  --}}
        </ul>
    </div>
</div>