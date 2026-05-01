@extends('customer.layouts.main')
{{-- Breadcrum --}}
@push('breadcrum')
    <div class="border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        {{ __('Workouts View') }}
    </div>
@endpush
@section('main-section')
    <section class="w-full px-6 mt-2 py-6">
        <div class="bg-white rounded-md p-6 shadow-lg">
            <table class="text-sm" cellpadding="4px">
                <tbody>
                    <x-table-row>
                        <td class="font-semibold ">
                            <span> {{ __('Name :') }}</span>
                        </td>
                        <td>
                            {{ $plan->name }}
                        </td>
                    </x-table-row>
                    <x-table-row>
                        <td class="font-semibold ">
                            <span class="font-semibold"> {{ __('Description :') }}</span>
                        </td>
                        <td>
                            {{ $plan->description }}
                        </td>
                    </x-table-row>
                </tbody>
            </table>

            <div class="border border-black rounded-md mt-10 overflow-auto">
                <table class="w-full text-left divide-y divide-black">
                    <thead>
                        <tr class="divide-x divide-black">
                            <th class="p-2"></th>
                            <th class="p-2">Monday</th>
                            <th class="p-2">Tuesday</th>
                            <th class="p-2">Wednesday</th>
                            <th class="p-2">Thursday</th>
                            <th class="p-2">Friday</th>
                            <th class="p-2">Saturday</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black text-sm">
                        @forelse ($weeks as $key => $week)
                            <tr class="divide-x divide-black">
                                <td class="p-4 text-lg font-semibold">Week {{ $key }}</td>
                                @foreach ($week as $day)
                                    <td class="p-4">
                                        <div>
                                            <p class="text-lg font-semibold py-2">{{ $day->category->name ?? 'Rest' }}</p>
                                            <ul class="list-disc px-4">
                                                @foreach ($day->exercises as $exercise)
                                                    <li>{{ $exercise->name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">{{ __('No Record Available') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
