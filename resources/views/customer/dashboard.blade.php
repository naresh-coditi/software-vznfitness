@extends('customer.layouts.main')
{{-- Breadcrum --}}
@push('breadcrum')
    <div class="border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        {{ __('Dashboard') }}
    </div>
@endpush
@section('main-section')
    <section>
        @if (!auth()->user()->userProfile->user_type)
            <header class="bg-yellow-300 py-4 text-center space-x-3">
                <h1 class="text-xl font-semibold inline-block">You have no active plan. Please buy an plan.</h1>
            </header>
        @endif
    </section>
@endsection
