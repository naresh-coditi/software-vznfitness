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
        <a>{{ __('Templates') }}</a>
    </span>
</div>
@endpush

@section('main-section')
<div class="w-full px-6 mt-2 py-2">
    <section class="flex flex-row justify-between md:flex-row items-center">
       <x-broadcast-div :all="$all" :value="$value" />
        <a href="{{ route(auth()->user()->roleName . 'sms.add') }}" class="bg-orange-600 text-white rounded-md px-4 py-2 hover:scale-95 hover:bg-orange-500 transition-transform duration-200">
            {{__('Add Template')}}
        </a>
    </section>

    {{-- Responsive Table --}}
    <x-table-element>
        <thead class="bg-gray-50">
            <x-table-row>
                <x-table-head>{{ __('Sr No.') }}</x-table-head>
                <x-table-head>{{ __('Title') }}</x-table-head>
                <x-table-head>{{ __('Subject') }}</x-table-head>
                <x-table-head>{{ __('Description') }}</x-table-head>
                <x-table-head>{{ __('Created At') }}</x-table-head>
                <x-table-head>{{ __('Actions') }}</x-table-head>
            </x-table-row>
        </thead>

        <tbody class="divide-y divide-gray-200 bg-white">
            @forelse ($templates as $key => $template)
            <x-table-row>
                <x-table-data>{{ $key + 1 }}</x-table-data>
                <x-table-data>{{ $template->title }}</x-table-data>
                <x-table-data>{{ $template->subject }}</x-table-data>
                <x-table-data>{{ Str::limit($template->description, 50) }}</x-table-data>
                <x-table-data>{{ dateFormat($template->created_at) }}</x-table-data>
                <x-table-data class="flex flex-row">
                    <a href="{{route(auth()->user()->roleName . 'sms.edit',$template)}}" class="text-blue-500 hover:text-blue-700">
                        <svg class="h-6 w-6 text-black hover:scale-125 " viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                            <line x1="16" y1="5" x2="19" y2="8" />
                        </svg>
                    </a>
                    <form action="{{route(auth()->user()->roleName . 'sms.delete',$template)}}" method="POST" class="inline-block ml-2 delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="text-red-500 hover:text-red-700 delete-button">
                            <svg class="h-6 w-6 text-red-500 hover:scale-125" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>

                        </button>
                    </form>
                </x-table-data>
            </x-table-row>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4 text-gray-500">
                    {{ __('No templates found') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </x-table-element>

    {{-- Pagination --}}
    <div class="py-3">
        {{ $templates->links() }}
    </div>
    @endsection

    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const form = this.closest('.delete-form');

                Swal.fire({
                    title: '{{ __("Are you sure?") }}',
                    text: '{{ __("You won’t be able to revert this!") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __("Yes, delete it!") }}',
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