@props(['values' => null, 'message', 'routename' => null, 'label' => false])

<div class="inline-block" x-data="{ deleteModal: false }" x-cloak x-init="$watch('deleteModal')">
    <button type="button" id="userDeleteModal" @click="deleteModal = true"
        class="flex items-center gap-2 hover:text-red-500 w-full">
        <svg class="w-4 h-4 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="#ff0000" aria-hidden="true">
            <title>Delete</title>
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0">
            </path>
            <title>{{ __('Delete') }}</title>
        </svg>
        @if ($label)
            <span>{{ is_string($label) && !empty($label) ? $label : __('Delete') }}</span>
        @endif
    </button>
    <input type="hidden" value="" id="userData" name="userData">
    <!-- Modal -->
    <div class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50 px-4"
        x-show="deleteModal" x-cloak>
        <!-- Modal inner -->
        <div class="max-w-3xl px-6 py-4 mx-auto text-left bg-white rounded shadow-lg " @click.away="deleteModal = false"
            x-transition:enter="motion-safe:ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100">
            <!-- Title / Close-->
            <div class="flex items-center justify-between">
                <h5 class="mr-3 text-black font-medium max-w-none">Delete</h5>

                <button type="button" class="z-50 cursor-pointer" @click="deleteModal = false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- content -->
            <div>
                <p class="text-lg mt-4 text-wrap">{{ $message }}</p>
                <div class="flex justify-content-end gap-4 mt-6">
                    <button @click ="deleteModal =false"
                        class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 mb-3">{{ 'Cancel' }}
                    </button>

                    <form action="{{ $routename }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit"
                            class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 mb-3 cursor-pointer">{{ 'Yes, Delete!' }}
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
