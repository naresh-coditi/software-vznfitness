@extends('admin.layouts.main')

{{-- In your Blade view file --}}

<!-- pop up for staff -->
@if (Auth::check() && Auth::user()->role_id == 2 && session('plans'))
    <x-staff-popup :plans="session('plans')" />
    {{ session()->forget('plans') }}
@endif
<!--  -->


{{-- Title --}}
@push('title')
    <title>{{ __('Dashboard') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="mb-4">
        <h2 class="text-2xl font-bold">{{ __('Dashboard') }}</h2>
        {{-- <span class="block text-xs font-normal text-gray-500 mt-2">
            <a>{{ __('Dashboard') }}</a>
        </span> --}}
    </div>
@endpush

{{-- Main Section --}}
@section('main-section')
    <section class="">
    <section class="flex flex-wrap items-start gap-6 md:gap-6 lg:gap-8">
    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 flex-grow">
        @can('isAdmin')
            <x-dashboard-tile href="{{ route(Auth::user()->roleName . 'staff.index') }}" label="Total Staff"
                color="bg-white text-gray-700" count="{{ $totalStaff }}">
                <x-slot name="img">
                <svg class="w-10 h-10 text-blue-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Free 6.7.2 --><path d="M96 128a128 128 0 1 0 256 0A128 128 0 1 0 96 128zm94.5 200.2l18.6 31L175.8 483.1l-36-146.9c-2-8.1-9.8-13.4-17.9-11.3C51.9 342.4 0 405.8 0 481.3c0 17 13.8 30.7 30.7 30.7l131.7 0c0 0 0 0 .1 0l5.5 0 112 0 5.5 0c0 0 0 0 .1 0l131.7 0c17 0 30.7-13.8 30.7-30.7c0-75.5-51.9-138.9-121.9-156.4c-8.1-2-15.9 3.3-17.9 11.3l-36 146.9L238.9 359.2l18.6-31c6.4-10.7-1.3-24.2-13.7-24.2L224 304l-19.7 0c-12.4 0-20.1 13.6-13.7 24.2z"></path></svg>
                </x-slot>
            </x-dashboard-tile>
        @endcan
        <x-dashboard-tile label="Total Member"  
            color="bg-white text-gray-700" count="{{ $totalMember }}">
            <x-slot name="img">
            <svg class="w-10 h-10 text-teal-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!-- Font Awesome Free 5.15.4 --><path d="M192 256c61.9 0 112-50.1 112-112S253.9 32 192 32 80 82.1 80 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C51.6 288 0 339.6 0 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zM480 256c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zm48 32h-3.8c-13.9 4.8-28.6 8-44.2 8s-30.3-3.2-44.2-8H432c-20.4 0-39.2 5.9-55.7 15.4 24.4 26.3 39.7 61.2 39.7 99.8v38.4c0 2.2-.5 4.3-.6 6.4H592c26.5 0 48-21.5 48-48 0-61.9-50.1-112-112-112z"></path></svg>
            </x-slot>
        </x-dashboard-tile>
        <x-dashboard-tile href="{{ route(Auth::user()->roleName . 'user.index') }}" label="Active Member"
            color="bg-white text-gray-700" count="{{ $ActiveMembers }}">
            <x-slot name="img">
            <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 16 16" fill="currentColor"><path fill="currentColor" d="M7.5 14.4c-0.8-0.8-0.8-2 0-2.8s2-0.8 2.8 0l0.6 0.6 1.9-2.1c-0.7-0.4-1.3-0.4-2-0.4-0.7-0.1-1.4-0.3-1.4-0.9s0.8-0.4 1.4-1.5c0 0 2.7-7.3-2.9-7.3-5.5 0-2.8 7.3-2.8 7.3 0.6 1 1.4 0.8 1.4 1.5s-0.7 0.7-1.4 0.8c-1.1 0.1-2.1-0.1-3.1 1.7-0.6 1.1-0.9 4.7-0.9 4.7h8l-1.6-1.6z"></path><path fill="currentColor" d="M12.8 16h2.1c0 0-0.1-0.9-0.2-2l-1.9 2z"></path><path fill="currentColor" d="M11 16c-0.3 0-0.5-0.1-0.7-0.3l-2-2c-0.4-0.4-0.4-1 0-1.4s1-0.4 1.4 0l1.3 1.3 3.3-3.6c0.4-0.4 1-0.4 1.4-0.1 0.4 0.4 0.4 1 0.1 1.4l-4 4.3c-0.3 0.3-0.5 0.4-0.8 0.4 0 0 0 0 0 0z"></path></svg>
            </x-slot>
        </x-dashboard-tile>
        <x-dashboard-tile href="{{ route(Auth::user()->roleName . 'lead.index') }}" label="Total Lead"
            color="bg-white text-gray-700" count="{{ $totalLead }}">
            <x-slot name="img">
            <svg class="w-10 h-10 text-purple-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1792 1792" fill="currentColor"><path d="M704 896c-212 0-384-172-384-384s172-384 384-384 384 172 384 384-172 384-384 384zm960 128h352c17 0 32 15 32 32v192c0 17-15 32-32 32h-352v352c0 17-15 32-32 32h-192c-17 0-32-15-32-32v-352h-352c-17 0-32-15-32-32v-192c0-17 15-32 32-32h352V672c0-17 15-32 32-32h192c17 0 32 15 32 32v352zm-736 224c0 70 58 128 128 128h256v238c-49 36-111 50-171 50H267c-160 0-267-96-267-259 0-226 53-573 346-573 16 0 27 7 39 17 98 75 193 122 319 122s221-47 319-122c12-10 23-17 39-17 85 0 160 32 217 96h-223c-70 0-128 58-128 128v192z"></path></svg>
            </x-slot>
        </x-dashboard-tile>
        <x-dashboard-tile href="{{ route(Auth::user()->roleName . 'upcoming.renewal.index') }}"
            label="Plan Expiring Soon (15 Days)" color="bg-white text-gray-700" count="{{ $expiringSoon }}">
            <x-slot name="img">
            <svg class="w-10 h-10 text-yellow-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!-- Font Awesome Free 6.7.2 --><path d="M224 0a128 128 0 1 1 0 256A128 128 0 1 1 224 0zM178.3 304l91.4 0c20.6 0 40.4 3.5 58.8 9.9C323 331 320 349.1 320 368c0 59.5 29.5 112.1 74.8 144L29.7 512C13.3 512 0 498.7 0 482.3C0 383.8 79.8 304 178.3 304zM352 368a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-80c-8.8 0-16 7.2-16 16l0 64c0 8.8 7.2 16 16 16l48 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-32 0 0-48c0-8.8-7.2-16-16-16z"></path></svg>
            </x-slot>
        </x-dashboard-tile>
        <x-dashboard-tile href="{{ route(Auth::user()->roleName . 'expired.plan.index') }}" label="Plan Expired"
            color="bg-white text-gray-700" count="{{ $expired }}">
            <x-slot name="img">
            <svg fill="currentColor" class="w-10 h-10 text-red-600" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
            <title>user-minus</title>
            <path d="M12 23c0-4.726 2.996-8.765 7.189-10.319 0.509-1.142 0.811-2.411 0.811-3.681 0-4.971 0-9-6-9s-6 4.029-6 9c0 3.096 1.797 6.191 4 7.432v1.649c-6.784 0.555-12 3.888-12 7.918h12.416c-0.271-0.954-0.416-1.96-0.416-3z"></path>
            <path d="M23 14c-4.971 0-9 4.029-9 9s4.029 9 9 9c4.971 0 9-4.029 9-9s-4.029-9-9-9zM28 24h-10v-2h10v2z"></path>
            </svg>
            </x-slot>
        </x-dashboard-tile>
        
    </div>
    
    <!-- Profile Card -->
    <div class="p-4 rounded-xl  w-full sm:max-w-sm bg-white transition-shadow duration-300  hidden 2xl:block">
        <div class="flex flex-col items-center">
            <div class="w-20 h-20 mb-4">
                <a href="{{ route(auth()->user()->roleName . 'profile.edit') }}">
                    <img class="rounded-full w-full h-full object-cover border-2 border-orange-600"
                        id="profileImage"
                        src="{{ profileImage($adminProfile->image->path) }}" alt="Profile Picture">
                </a>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{($adminProfile->role_id===1) ? 'ADMIN' : 'STAFF'}}</h2>
            <table class="table-auto w-full text-sm text-left text-gray-600">
                <tbody>
                    <tr class="border-b">
                        <th class="py-2 px-4 font-medium text-gray-800">Name:</th>
                        <td class="py-2 px-4">{{ $adminProfile->userProfile->fullname }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 px-4 font-medium text-gray-800">Email:</th>
                        <td class="py-2 px-4">{{ $adminProfile->email }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 px-4 font-medium text-gray-800">Phone:</th>
                        <td class="py-2 px-4">{{ $adminProfile->phone }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 px-4 font-medium text-gray-800">Member ID:</th>
                        <td class="py-2 px-4">{{ $adminProfile->member_id }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 font-medium text-gray-800">Profile Created On:</th>
                        <td class="py-2 px-4">{{ dateFormat($adminProfile->created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

        @can('isAdmin')
            <section class="py-4 flex flex-col gap-y-6">
                <div class="flex md:flex-row flex-col gap-x-6 gap-y-6 md:gap-y-0">
                    <div class="md:w-1/2 bg-white border rounded-lg shadow-md shadow-gray-100/30">
<x-liability-card :liabilities="$liabilities" />
                    </div>
                    <div class="md:w-1/2 bg-white p-4 border rounded-lg shadow-md shadow-gray-100/30">
                        <div class="flex items-center justify-between gap-6">
                            <h2>{{ __('Total Sales : ₹ ') . array_sum($monthlySalesData) }}</h2>
                            <form action="{{ route(auth()->user()->roleName . 'dashboard') }}" method="get" id="monthlySalesForm"
                                class="flex items-center gap-3">
                                <select name="month" id="month" onchange="submitHandler()"
                                    class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                    @foreach ($months as $key => $month)
                                        <option value="{{ $key }}" {{ $selectedMonth == $key ? 'selected' : '' }}>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="year" id="year" onchange="submitHandler()"
                                    class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                    @for ($minYear; $minYear <= $maxYear; $minYear++)
                                        <option value="{{ $minYear }}" {{ $selectedYear == $minYear ? 'selected' : '' }}>
                                            {{ $minYear }}
                                        </option>
                                    @endfor
                                </select>
                            </form>
                        </div>
                        <div class="py-2 w-full">
                            <canvas id="monthlySalesChart"></canvas>
                        </div>
                    </div>
                    <div class="md:w-1/2 bg-white p-4 border rounded-lg shadow-md shadow-gray-100/30">
                        <div class="py-2 w-full">
                            <canvas id="dailySalesChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="w-full bg-white p-4 border rounded-lg shadow-md shadow-gray-100/30">
                    <div class="flex items-center justify-between gap-6">
                        <h3 class="text-lg ">User Membership Data</h3>
                    </div>
                    <div class="py-2 w-full h-full">
                        <canvas id="membershipChart"></canvas>
                    </div>
                </div>
            <!-- chart for membershipData -->
        </section>
        @endcan
        @cannot('isAdmin')
        <section x-data="notes">
            <x-today-follow-up-listing :leads="$leads" />
            <x-modal.notes-modal />
        </section>
        @endcannot
    </section>
@endsection
@push('script')
    <script>
        function submitHandler() {
            document.getElementById('monthlySalesForm').submit();
        }
        // Monthly sales
        const ctx = document.getElementById('monthlySalesChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($monthlySalesData)) !!},
                datasets: [{
                    label: 'Sales as per month',
                    data: {!! json_encode(array_values($monthlySalesData)) !!},
                    borderWidth: 1,
                    backgroundColor: '#ea580c',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: true
            }
        });

        // Daily Sales
        const dailySale = document.getElementById('dailySalesChart');
        new Chart(dailySale, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($dailySalesData->toArray())) !!},
                datasets: [{
                    label: 'Total sales per day',
                    data: {!! json_encode(array_values($dailySalesData->pluck('total')->toArray())) !!},
                    borderWidth: 1,
                    backgroundColor: '#ea580c',
                }, {
                    label: 'CASH',
                    data: {!! json_encode(array_values($dailySalesData->pluck('cash')->toArray())) !!},
                    borderWidth: 1,
                    backgroundColor: 'green',
                }, {
                    label: 'EMI',
                    data: {!! json_encode(array_values($dailySalesData->pluck('emi')->toArray())) !!},
                    borderWidth: 1,
                    backgroundColor: 'blue',
                }, {
                    label: 'CARD',
                    data: {!! json_encode(array_values($dailySalesData->pluck('card')->toArray())) !!},
                    borderWidth: 1,
                    backgroundColor: 'red',
                }, {
                    label: 'UPI',
                    data: {!! json_encode(array_values($dailySalesData->pluck('upi')->toArray())) !!},
                    borderWidth: 1,
                    backgroundColor: 'yellow',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: true
            }
        });

        // active membership users data
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('membershipChart');

            const membershipPlans = @json($membershipPlans);
            const membershipData = @json($membershipData);

            const data = {
                labels: membershipPlans, // Membership plan names on the x-axis
                datasets: [{
                    label: `Active Users`,
                    data: membershipPlans.map(plan => membershipData[plan] ||
                        0), // Users per membership plan
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ], // Border color for bars
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'bar', // Bar chart type
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Ensure y-axis starts from 0
                        }
                    },
                    responsive: true, // Make the chart responsive
                }
            };

            // Create the chart
            const membershipChart = new Chart(ctx, config);
        });
    </script>
@endpush
