@extends('admin.layouts.main')

{{-- Title --}}
@push('title')
<title>{{ __('SMS Templates') }}</title>
@endpush

{{-- Breadcrumb --}}
@push('breadcrum')
<div class="pl-6 py-2 md:mt-10 mt-5 text-xl font-bold">
    <span>{{ __('SMS Templates') }}</span>
    <span class="block text-xs font-normal text-gray-500 mt-2">
        <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
        &raquo;
        <a href="{{ route(auth()->user()->roleName . 'sms.index') }}">{{ __('Templates') }}</a>
    </span>
</div>
@endpush

@section('main-section')
<section class="max-w-4xl mx-auto px-6 py-8 bg-white shadow-lg rounded-lg">
<div class="text-center mb-6">
    <h2 class="flex items-center justify-center text-2xl font-semibold text-gray-700">
        Sending 
        <svg class="h-8 w-8 text-orange-500 mr-2 ml-2 hover:scale-110" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" />
            <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
            <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
        </svg> 
        To <span class="text-orange-500 ml-2">{{$user->first_name.' '.$user->last_name}}</span>
    </h2>
</div>



    {{-- Form --}}
    <form action="{{ route(auth()->user()->roleName . 'sms.store',$template) }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6">
            {{-- Title Field --}}
            <div class="flex flex-col">
                <label for="title" class="mb-2 font-medium text-gray-700">{{ __('Title') }}</label>
                <input type="text" name="title" id="title" value="{{$template->title}}" placeholder="{{ __('Enter title') }}"
                    class="border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500 p-3">
                @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            {{-- Message --}}
            <div class="flex flex-col mb-4">
                <label for="sms" class="mb-2 font-medium text-gray-700">{{ __('SMS') }}</label>
                <textarea name="sms" id="sms" rows="5" placeholder="{{ __('Enter sms') }}"
                    class="border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500 p-3"> {{ old('sms', str_replace('{Member}', $user->first_name.' '.$user->last_name, $template->description)) }}</textarea>
                @error('sms')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

        </div>

        {{-- Submit Button --}}
        <div class="flex justify-center mt-6">
            <button type="button" class="send-sms-button bg-green-600 text-white px-6 py-3 rounded-md shadow-md hover:bg-green-700 hover:scale-95">
            {{__('Send')}}
            </button>
            <a href="{{ route(auth()->user()->roleName . 'lead.index') }}" class="bg-red-500 text-white px-6 py-4 ml-2 rounded-md shadow-md hover:bg-red-600 transition duration-200 hover:scale-95">
                {{ __('Cancel') }}
            </a>
        </div>
    </form>
</section>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.send-sms-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const form = this.closest('.send-sms-form');

            Swal.fire({
                title: '{{ __("Are you sure?") }}',
                text: '{{ __("Do you really want to send this SMS?<br>".$user->phone) }}',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __("Yes, send it!") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endpush