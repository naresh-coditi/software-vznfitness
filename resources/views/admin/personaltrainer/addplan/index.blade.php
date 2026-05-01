@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __('Personal Trianing Plan') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="pl-6 py-2 mt-10  text-xl font-bold">
        <span>{{ __('Personal Training Plan') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
            &raquo;
            <a>{{ __('Add Personal Training Plan') }}</a>
        </span>
    </div>
@endpush
@section('main-section')
    <section class="w-full px-6 mt-2 py-6">
        {{-- New Comment --}}
        <div class="xl:w-2/3 m-auto w-full rounded-lg">
            <form action="{{ route(auth()->user()->roleName . 'pt.plan.store', $user) }}" id="createUserForm" method="post"
                class="bg-white mb-10 p-6 rounded-md">
                @csrf
                <div class="space-y-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 mb-4">Add PT Plan</h2>

                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                        {{-- Trainer namae --}}

                        <div class="sm:col-span-3">
                            <x-input-label for="trainer" :value="__('Trainer Name')" />
                            <select name="trainer" id="trainer" required
                                class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                <option value="" disabled selected>{{ __('Select') }}</option>
                                @foreach ($trainers as $trainer)
                                    <option value="{{ $trainer->id }}">
                                        {{ '(' . $trainer->member_id . ') ' . $trainer->userProfile->fullName }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('trainer')" class="mt-2" />
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
                        {{-- Amount --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="amount" :value="__('Amount')" astrik />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount"
                                :value="old('amount')" required autofocus autocomplete="amount" />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>
                        {{-- Remaining Balance --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="remaining_balance" :value="__('Remaining Balance')" />
                            <x-text-input id="remaining_balance" class="block mt-1 w-full" type="number"
                                name="remaining_balance" :value="old('remaining_balance')" required autofocus
                                autocomplete="remaining_balance" />
                            <x-input-error :messages="$errors->get('remaining_balance')" class="mt-2" />
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

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route(auth()->user()->roleName . 'pt.index') }}"
                        class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <button type="submit"
                        class="rounded-md bg-orange-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline-orange-500">Create</button>
                </div>
            </form>

            {{-- old notes --}}
            <div class="max-w-6xl m-auto border-x mt-10 bg-white rounded-md overflow-x-auto">
                <x-table-element>
                    <thead class="bg-gray-50">
                        <x-table-row>
                            <x-table-head>
                                {{ __('Sr No.') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Member Name') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Trianer Name') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Payment Method') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Amount') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Remaining Balance') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Duration') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Start Date') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('End Date') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Actions') }}
                            </x-table-head>
                        </x-table-row>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($datas as $key => $data)
                            <x-table-row>
                                <x-table-data>
                                    <span>{{ $key + $datas->firstItem() }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span
                                        class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                                        {{ $data->memberProfile->fullName }}
                                    </span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ $data->trainer }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ $data->method_type }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ $data->amount }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ $data->remaining_balance }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ $data->duration }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ dateformat($data->start_date) }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ dateformat($data->end_date) }}</span>
                                </x-table-data>
                                {{-- Action --}}
                                <x-table-data class="relative">
                                    <x-delete-confirmation-modal :values="$data" :message="'Are you sure you want to remove this record ?'"
                                        routename="{{ route(auth()->user()->roleName . 'pt.plan.delete', $data) }}" />
                                    </a>
                                </x-table-data>
                            </x-table-row>
                        @empty
                            <x-table-row>
                                <x-table-data colspan="8">
                                    {{ __('No Record Found') }}
                                </x-table-data>
                            </x-table-row>
                        @endforelse
                    </tbody>
                </x-table-element>
            </div>
    </section>

    @push('script')
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
@endsection
