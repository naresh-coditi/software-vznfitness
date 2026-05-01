@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __('Exercises') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'exercises.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Upload Gallery') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'exercises.index') }}">{{ __('Exercises') }}</a>
                &raquo;
                <a>{{ __('Upload Gallery') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2">
        <div class="bg-white rounded-md shadow-lg border p-6">
            <table class="text-sm" cellpadding="4px">
                <tbody>
                    <x-table-row>
                        <td class="font-semibold">
                            <span> {{ __('Name :') }}</span>
                        </td>
                        <td>
                            {{ $exercise->name }}
                        </td>
                    </x-table-row>
                    <x-table-row>
                        <td class="font-semibold">
                            <span class="font-semibold"> {{ __('Description :') }}</span>
                        </td>
                        <td>
                            {{ $exercise->description }}
                        </td>
                    </x-table-row>
                    <x-table-row>
                        <td class="font-semibold">
                            <span class="font-semibold"> {{ __('Category Name :') }}</span>
                        </td>
                        <td>
                            {{ $exercise->category->name }}
                        </td>
                    </x-table-row>
                </tbody>
            </table>
            <div class="mt-10">
                <!-- Example of a form that Dropzone can take over -->
                <form class="dropzone bg-orange-50 border border-orange-500 border-dashed text-orange-500 rounded-md"
                    id="my-form" enctype="multipart/form-data">
                    @csrf
                </form>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        Dropzone.autoDiscover = false;

        let myDropzone = new Dropzone("#my-form", {
            url: @js(route(auth()->user()->roleName . 'exercises.upload.store', $exercise)),
            chunking: true,
            previewsContainer: '#my-form',
            method: "POST",
            maxFilesize: 10, // in MB
            maxFiles: 20,
            chunkSize: 1000000,
            paramName: 'file',
            addRemoveLinks: true,
            acceptedFiles: ".jpeg,.jpg,.png,image/*",
            autoProcessQueue: true,
            init: async function() {
                var myDropzone = this;
                fetch(@js(route(auth()->user()->roleName . 'exercises.upload.index', $exercise)))
                    .then(response => response.json())
                    .then(images => {
                        if (images.length > 0) {
                            images.forEach(function(image) {
                                // Create a mock file object
                                const url = @js(asset('storage/'));
                                var mockFile = {
                                    id: image.id,
                                    name: image.name, // Use image.name if it exists
                                    type: image.type,
                                    size: image.size,
                                    path: url + '/' + image
                                        .path // Ensure 'path' is available in your response
                                };

                                myDropzone.emit("addedfile", mockFile);
                                // Call the default addedfile event handler
                                myDropzone.emit("thumbnail", mockFile, mockFile.path);
                                // Mark the file as complete
                                myDropzone.emit("complete", mockFile);
                            });
                        }
                    })
                    .catch(error => console.error('Error fetching images:', error));
            },
            removedfile: async function(file) {
                if (file.id) {
                    try {
                        const formData = new FormData();
                        formData.append('id', file.id);

                        const response = await fetch(@js(route(auth()->user()->roleName . 'exercises.upload.delete', $exercise)), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': @js(csrf_token())
                            },
                            body: formData
                        });

                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }

                        const data = await response.json();

                        file.previewElement.parentNode.removeChild(file.previewElement);
                    } catch (error) {
                        console.error('There was a problem with the fetch operation:', error);
                        return {
                            error: error.message
                        };
                    }
                } else {
                    file.previewElement.parentNode.removeChild(file.previewElement);
                }
            },
            success: function(file, response) {
                file.id = response.id;
            },
            error: function(file, response) {
                alert(response.message);
            },
        });
    </script>
@endpush
