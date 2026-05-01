<x-filters.filter>
    <!-- <div class="mt-4">
        <input type="text"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-2 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out"
            name="search" value="{{ request('search') }}" placeholder="Search name..." id="filterName">
    </div> -->

    <!-- Filter Option 2 (Order By Dropdown) -->
    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Order By</label>
        <select id="orderby"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-2 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out"
            name="orderby">
            <option value="0" {{ request('orderby') == '0' ? 'selected' : '' }}>All</option>
            <option value="1" {{ request('orderby') == '1' ? 'selected' : '' }}>Remaining Balance
            </option>
            <option value="2" {{ request('orderby') == '2' ? 'selected' : '' }}>Membership</option>
            <option value="3" {{ request('orderby') == '3' ? 'selected' : '' }}>Plan Expired</option>
        </select>
    </div>
</x-filters.filter>
