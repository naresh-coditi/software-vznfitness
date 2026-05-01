@props(['class' => null])
<div x-data="{ dropDown: false }" class="relative">
    <button @click="dropDown = true" class="flex items-center text-gray-700 focus:text-gray-900 font-semibold rounded "
        type="button">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            viewBox="0 0 16 16">
            <path
                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0">
            </path>
        </svg>
    </button>
    <ul x-show="dropDown" x-cloak @click.away="dropDown = false"
        class="bg-white border border-gray-300 rounded-md text-gray-700 shadow-lg absolute top-0 py-2 mt-1 z-40 space-y-2 px-2 {{ $class }} min-w-32">
        {{ $slot }}
    </ul>
</div>
