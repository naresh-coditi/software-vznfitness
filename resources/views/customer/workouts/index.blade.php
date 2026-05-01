@extends('customer.layouts.main')
{{-- Breadcrum --}}
@push('breadcrum')
    <div class="border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        {{ __('Workouts') }}
    </div>
@endpush
@section('main-section')
    <section class="px-6 py-4">
        <x-table-element class="!min-w-[75%] m-auto">
            <thead  class="bg-gray-50">
                <x-table-row class=" divide-x divide-gray-200">
                    <x-table-head class="px-4 w-3/4">
                        <span>{{ __('Plan name') }}</span>
                    </x-table-head>
                    <x-table-head class="px-4 w-1/4">
                        {{ __('View workout') }}
                    </x-table-head>
                </x-table-row>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($plans as $plan)
                    <x-table-row class=" divide-x divide-gray-200">
                        <x-table-data class="px-4">
                            <span>{{ $plan->name }}</span>
                        </x-table-data>
                        <x-table-data  class="px-4">
                            <a href="{{ route('user.workouts.view', $plan) }}">
                                {{ __('View') }}
                            </a>
                        </x-table-data>
                    </x-table-row>
                @empty
                    <x-table-row>
                        <x-table-data colspan="2">
                            <p>No workout plan added yet!</p>
                        </x-table-data>
                    </x-table-row>
                @endforelse
            </tbody>
        </x-table-element>
    </section>
@endsection
