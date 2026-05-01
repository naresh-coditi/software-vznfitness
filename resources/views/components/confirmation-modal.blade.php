@props(['name', 'id'])
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="fixed z-10 inset-0 overflow-y-auto" x-data="{ show: false, name: '{{ $name }}' }" x-show="show" x-cloak
    x-on:modal.window="
        show = ($event.detail === name);
     " @keydown.escape.window="show = false"
    :id="name" style="display: none" class="fixed inset-0 grid place-items-center" {{ $attributes }}>

    <div class="flex items-center sm:items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!--
    Background overlay, show/hide based on modal state.

    Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
    Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
        <div class="fixed inset-0 backdrop-grayscale bg-black/30 transition-opacity"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
            From: "opacity-100 translate-y-0 sm:scale-100"
            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            x-show.transition="show" x-cloak>
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">

                    <!-- add icon -->
                    @if (isset($icon))
                        {{ $icon ?? '' }}
                    @endif

                    <div class="mt-3 ml-4 sm:mt-0 w-full">
                        @if (isset($title))
                            <h5 class="text-lg leading-6 font-medium text-gray-900" id="{{ Str::slug($title) }}-title">
                                {{ $title }}</h5>
                        @endif

                        <div>
                            {{ $body }}
                        </div>
                    </div>
                </div>
            </div>
            @if (isset($footer))
                <div
                    class="px-4 py-3 sm:px-6 grid grid-cols-2 sm:flex sm:flex-row-reverse text-sm space-x-4 sm:space-x-reverse">
                    {{ $footer ?? '' }}
                </div>
            @endif
        </div>
    </div>
</div>
