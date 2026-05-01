<x-modal name="workoutcategoryCreate" maxWidth="xl" :show="session('modalName') == 'workoutcategoryCreate'" focusable>
    <section class="px-6 py-4">
        <header class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-950">{{ __('Create Category') }}</h2>
            <button x-on:click="$dispatch('close')"
                class="flex items-center justify-center w-8 h-8 text-black bg-purple-200 rounded focus:outline-none hover:text-gray-700">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 21" fill="currentColor">
                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" transform="translate(5 5)">
                        <path d="m10.5 10.5-10-10z"></path>
                        <path d="m10.5.5-10 10"></path>
                    </g>
                </svg>
            </button>
        </header>
        <div class="flex items-center justify-center">
            <form action="{{ route(auth()->user()->roleName . 'workout.categories.store') }}" method="post"
                class="w-full">
                @csrf
                <div>
                    {{-- Name --}}
                    <div class="sm:col-span-3">
                        <x-input-label for="name" :value="__('Plan Name')" astrik />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="description" :value="__('Plan Description')" astrik />
                        <textarea id="message" rows="4" name="description"
                            class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                            placeholder="Write description..."></textarea>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route(auth()->user()->roleName . 'workout.categories.index') }}"
                        class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <x-primary-button>Submit</x-primary-button>
                </div>
            </form>
        </div>
    </section>
</x-modal>
