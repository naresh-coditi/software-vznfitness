<x-filters.filter>
    <!-- Search input -->
    <div class="mt-4">
        <input type="text"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-2 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out"
            name="search" value="{{ request('search') }}" placeholder="Search name..." id="filterName">
    </div>

    <!-- Dropdown for Order By -->
    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Order By</label>
        <select id="orderby"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-2 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out"
            name="orderby">
            <option value="0" {{ request('orderby') == '0' ? 'selected' : '' }}>All</option>
            <option value="1" {{ request('orderby') == '1' ? 'selected' : '' }}>Name</option>
            <option value="2" {{ request('orderby') == '2' ? 'selected' : '' }}>Remaining Balance
            </option>
            <option value="3" {{ request('orderby') == '3' ? 'selected' : '' }}>Plan Expired</option>
            <option value="4" {{ request('orderby') == '4' ? 'selected' : '' }}>Follow Up Date</option>
        </select>
    </div>
</x-filters.filter>
