@props(['paymentMethods' => null])
<x-filters.filter>
    <!-- Search input -->
    <div class="mt-4">
        <x-input-label for="method_type" class="text-xs" :value="__('Search')" />
        <input type="text"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-2 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out"
            name="search" value="{{ request('search') }}" placeholder="Search name..." id="filterName">
    </div>

    <!-- Dropdown for Order By -->
    <div>
        <x-input-label for="method_type" class="text-xs" :value="__('Payment Method')" />
        <select name="method_type" id="method_type" autofocus
            class="block w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
            <option value="" selected>{{ __('All') }}</option>
            @foreach ($paymentMethods as $method)
                <option value="{{ $method['name'] }}" {{ request('method_type') == $method['name'] ? 'selected' : '' }}>
                    {{ $method['name'] }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="w-full">
        <x-input-label for="date_range" class="text-xs" :value="__('Transaction Dates')" />
        <input type="text" name="date_range" id="date_range" class="w-full" value="{{ request('date_range') }}">
    </div>
</x-filters.filter>
