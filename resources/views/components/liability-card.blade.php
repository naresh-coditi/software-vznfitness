@props(['liabilities'])

<div class="px-4 py-2 rounded-lg border text-black w-full relative md:col-span-2 bg-white h-52 overflow-y-auto">
    <h3 class="text-xl font-semibold text-orange-600 mb-4 text-center hover:scale-105"><a href="{{ route(auth()->user()->roleName . 'liability.index') }}">Liabilities</a></h3>
    <svg class="w-6 h-6 text-orange-500 absolute top-3 right-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"></path>
    </svg>
    <div class="w-full">
        <div class="mb-4 w-full">
            <div class="flex justify-between items-center py-2 border-b">
                <span class="text-sm font-medium text-gray-700">₹500-₹1000</span>
                <span class="text-sm font-semibold text-gray-900">{{ $liabilities['range1'] }} Members</span>
            </div>
        </div>
        <div class="mb-4 w-full">
            <div class="flex justify-between items-center py-2 border-b">
                <span class="text-sm font-medium text-gray-700">₹1000-₹1200</span>
                <span class="text-sm font-semibold text-gray-900">{{ $liabilities['range2'] }} Members</span>
            </div>
        </div>
        <div class="mb-4 w-full">
            <div class="flex justify-between items-center py-2 border-b">
                <span class="text-sm font-medium text-gray-700">₹1200-₹1500</span>
                <span class="text-sm font-semibold text-gray-900">{{ $liabilities['range3'] }} Members</span>
            </div>
        </div>
        <div class="mb-4 w-full">
            <div class="flex justify-between items-center py-2 border-b">
                <span class="text-sm font-medium text-gray-700">₹1500-₹1800</span>
                <span class="text-sm font-semibold text-gray-900">{{ $liabilities['range4'] }} Members</span>
            </div>
        </div>
        <div class="mb-4 w-full">
            <div class="flex justify-between items-center py-2 border-b">
                <span class="text-sm font-medium text-gray-700">₹1800-₹2000</span>
                <span class="text-sm font-semibold text-gray-900">{{ $liabilities['range5'] }} Members</span>
            </div>
        </div>
        <div class="mb-4 w-full">
            <div class="flex justify-between items-center py-2">
                <span class="text-sm font-medium text-gray-700">₹2000+</span>
                <span class="text-sm font-semibold text-gray-900">{{ $liabilities['range6'] }} Members</span>
            </div>
        </div>
    </div>
</div>