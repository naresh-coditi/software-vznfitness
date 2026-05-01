<x-confirmation-modal name="statusModal">
    <x-slot name="title">{{ __('Plan Status') }}</x-slot>
    <x-slot name="body">
        <!-- Body of the modal -->
        <x-slot name="icon">
            <div id="activeIcon"
                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12
                rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                <x-icon-activate-status />
            </div>
            <div id="deactiveIcon"
                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12
                rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <x-icon-error />
            </div>
        </x-slot>
        <form action="#" method="post" class="mb-0">
            @csrf
            @method('patch')
            <p class="text-sm text-gray-500 mt-4" id="activePara">
                {{ __('Are you sure you want to Active the plan status?') }}
            </p>
            <p class="text-sm text-gray-500 mt-4" id="deactivePara">
                {{ __('Are you sure you want to Deactive the plan status?') }}
            </p>
            <div class="mt-6 grid grid-cols-2 sm:flex sm:flex-row-reverse text-sm space-x-4 sm:space-x-reverse">
                <button type="button" id="activeBtn" @click="formSubmit($event)"
                    class="btn px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
                    {{ __('Active Plan') }}
                </button>
                <button type="button" id="deactiveBtn" @click="formSubmit($event)"
                    class="btn px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                    {{ __('Deactive Plan') }}
                </button>
                <a href="javascript:void(0);" @click="show = false;location.reload()"
                    class="inline-flex justify-center rounded border border-gray-300
                        px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700
                        shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300
                        focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </x-slot>
</x-confirmation-modal>
