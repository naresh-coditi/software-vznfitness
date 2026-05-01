<x-filters.filter>
    <div class="mt-4">
        <input type="text"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-2 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out"
            name="search" value="{{ request('search') }}" placeholder="Search name..." id="filterName">
    </div>
</x-filters.filter>
