@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Personal Trainer') }}</title>
@endpush

@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'pt.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Personal Trainer') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'pt.index') }}">{{ __('Personal Trainer') }}</a> &raquo;
                <a>{{ __('Create') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 py-6">
        <div>
            <form action="{{ route(auth()->user()->roleName . 'pt.store') }}" id="createUserForm" method="post">
                @csrf
                <input type="hidden" name="user_type" value="1">
                <div class="space-y-12">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                        <div>
                            <h2 class="text-base font-semibold leading-7 text-gray-900">PT Information</h2>
                        </div>

                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                            {{-- Member Name --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="member" :value="__('Member Name')" astrik />
                                <select name="member" id="member" class="member"
                                    class="block mt-1 border-gray-300  rounded-md shadow-sm w-full">
                                    <option value="" checked>Select Member</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ '(' . $user->member_id . ') ' . $user->userProfile->fullName }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('member')" class="mt-2" />
                            </div>
                            {{-- Trainer name --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="trainer" :value="__('Trainer Name')" astrik />
                                <select name="trainer" id="trainer" class="trainer"
                                    class="block mt-1 border-gray-300  rounded-md shadow-sm w-full">
                                    <option value="" checked>Select Trainer</option>
                                    @foreach ($trainers as $trainer)
                                        <option value="{{ $trainer->id }}">
                                            {{ '(' . $trainer->member_id . ') ' . $trainer->userProfile->fullName }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('trainer')" class="mt-2" />
                            </div>
                            {{-- Amount --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="amount" :value="__('Amount')" astrik />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount"
                                    :value="old('amount')" required autofocus autocomplete="amount" />
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>
                            <!-- Remaining Balance -->
                            <div class="sm:col-span-3">
                                <x-input-label for="remaining_balance" :value="__('Remaining Balance')" />
                                <x-text-input id="remaining_balance" class="block mt-1 w-full" type="number"
                                    name="remaining_balance" :value="old('remaining_balance')" required autofocus
                                    autocomplete="remaining_balance" />
                                <x-input-error :messages="$errors->get('remaining_balance')" class="mt-2" />
                            </div>
                            {{-- Method Type --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="method_type" :value="__('Method Type')" />
                                <select name="method_type" id="method_type" required
                                    class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                    <option value="" disabled selected>{{ __('Select') }}</option>
                                    @foreach ($methods as $method)
                                        <option value="{{ $method['name'] }}"
                                            {{ $method['name'] == old('method_type') ? 'selected' : '' }}>
                                            {{ $method['name'] }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('method_type')" class="mt-2" />
                            </div>
                            {{-- Duration --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="duration" :value="__('Duration')" astrik />
                                <select name="duration" id="duration"
                                    class="w-full block mt-1 border-gray-300 rounded-md shadow-sm">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i.' month' }}">{{ __("$i month") }}</option>
                                    @endfor
                                </select>
                                <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                            </div>
                            {{-- Start date --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="start_date" :value="__('Start Date')" astrik />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date"
                                    placeholder="Enter start_date" name="start_date" :value="old('start_date')" required autofocus
                                    autocomplete="start_date" />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            {{-- End date --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="end_date" :value="__('End Date')" astrik />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date"
                                    placeholder="Enter end_date" name="end_date" :value="old('end_date')" required autofocus
                                    autocomplete="end_date" />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route(auth()->user()->roleName . 'pt.index') }}"
                        class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <button type="submit"
                        class="rounded-md bg-orange-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline-orange-500">Create</button>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ asset('js/choicejs.min.js') }}"></script>
    <script>
        const select = new Choices('.member', {
            searchEnabled: true,
            searchChoices: true,
            itemSelectText: '',
            allowHTML: true,
            removeItems: true,
            addItems: true,
            position: 'auto',
            removeItemButton: true,
            classNames: {
                containerOuter: 'choices select-choices',
            },
        });
        const trainer = new Choices('.trainer', {
            searchEnabled: true,
            searchChoices: true,
            itemSelectText: '',
            allowHTML: true,
            removeItems: true,
            addItems: true,
            position: 'auto',
            removeItemButton: true,
            classNames: {
                containerOuter: 'choices select-choices',
            },
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const membershipDuration = document.getElementById('duration');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            function calculateEndDate() {
                const duration = parseInt(membershipDuration.value, 10); // Duration in months
                const startDateValue = startDateInput.value;

                if (!isNaN(duration) && startDateValue) {
                    const startDate = new Date(startDateValue);
                    const adjustedEndDate = new Date(startDate);

                    // Add months based on selected duration
                    adjustedEndDate.setMonth(adjustedEndDate.getMonth() + duration);

                    // Adjust for month overflow (e.g., from Jan 31 to Feb)
                    if (adjustedEndDate.getDate() !== startDate.getDate()) {
                        adjustedEndDate.setDate(0); // Set to last day of previous month if overflow happens
                    }

                    // Format the date as YYYY-MM-DD
                    const year = adjustedEndDate.getFullYear();
                    const month = String(adjustedEndDate.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                    const day = String(adjustedEndDate.getDate()).padStart(2, '0');

                    endDateInput.value = `${year}-${month}-${day}`;
                }
            }

            // Listen for changes on membership duration and start date
            membershipDuration.addEventListener('change', calculateEndDate);
            startDateInput.addEventListener('change', calculateEndDate);
        });
    </script>
@endpush
