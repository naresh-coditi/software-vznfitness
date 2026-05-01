@extends('customer.layouts.main')
@section('main-section')
    {{-- Breadcrum --}}
    @push('breadcrum')
        <div class="border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
            {{ __('Profile') }}
        </div>
    @endpush
    <section class="w-full px-6 mt-2 py-6">
        <div class="md:flex gap-8 pt-4">
            <div class="flex flex-col xl:flex-row justify-between w-full gap-10">
                <div class="dark:border-gray-700 dark:bg-gray-800">
                    <div
                        class="xl:block xl:space-x-0 2xl:space-x-4 p-6 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <h3 class="mb-4 text-sm font-bold text-gray-900 dark:text-white">Profile picture</h3>
                        <img class="mb-4 rounded-lg h-full w-full sm:mb-0 xl:mb-4 2xl:mb-0 object-cover" id="profileImage"
                            src="{{ profileImage($user->image->path) }}" alt="Jese picture">
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-10 w-full">
                    <x-table-element class="text-sm sm:w-2/4">
                        <tbody>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('First Name') }}</div>
                                </x-table-data>
                                <x-table-data>
                                    {{ $user->userProfile->first_name }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Last Name') }}</div>
                                </x-table-data>
                                <x-table-data>
                                    {{ $user->userProfile->last_name }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Gender') }}</div>
                                </x-table-data>
                                <x-table-data>
                                    <p class="text-sm">{{ $user->userProfile->gender }}</p>
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Remaining Balance') }}</div>
                                </x-table-data>
                                <x-table-data>
                                    {{ $user->latestPlan->remaining_amount }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Start Date') }} </div>
                                </x-table-data>
                                <x-table-data>
                                    {{ dateFormat($user->latestPlan->start_date) }}
                                </x-table-data>
                            </x-table-row>
                        </tbody>
                    </x-table-element>
                    <x-table-element class="text-sm sm:w-2/4">
                        <tbody>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Address') }}</div>
                                </x-table-data>
                                <x-table-data>
                                    {{ $user->userProfile->address }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Phone Number') }} </div>
                                </x-table-data>
                                <x-table-data>
                                    {{ $user->phone }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Membership Name') }}</div>
                                </x-table-data>
                                <x-table-data>
                                    {{ $user->latestPlan->name }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div>r</div>
                                </x-table-data>
                                <x-table-data>
                                    <div></div>
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('End Date') }}</div>
                                </x-table-data>
                                <x-table-data>
                                    {{ dateFormat($user->latestPlan->end_date) }}
                                </x-table-data>
                            </x-table-row>
                        </tbody>
                    </x-table-element>
                </div>
            </div>
        </div>
    </section>
@endsection
