@props(['noteType' => null])
@php
    $type = $noteType;
@endphp

<x-modal name="userNotes" maxWidth="5xl" :show="session('modalName') == 'userNotes'" focusable>
    <div class="py-6 bg-white rounded-md">
        <section class="py-2 px-4">
            <header class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-950">{{ __('Notes') }}</h2>
                <button x-on:click="$dispatch('close')"
                    class="flex items-center justify-center w-8 h-8 text-black bg-purple-200 rounded focus:outline-none hover:text-gray-700">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 21" fill="currentColor">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" transform="translate(5 5)">
                            <path d="m10.5 10.5-10-10z"></path>
                            <path d="m10.5.5-10 10"></path>
                        </g>
                    </svg>
                </button>
            </header>
            <section class="w-full px-6 mt-2 py-6">
                {{-- New Comment --}}
                <div class="bg-white m-auto w-full rounded-lg p-6">
                    <form method="post" class="gap-2" id="add_note">
                        @csrf
                        <input type="hidden" name="type" value="{{ $noteType }}">
                        <div class="w-full">
                            <label class="block mb-2 text-sm text-gray-900 font-semibold" for="note">
                                {{ __('Enter Note') }}
                            </label>
                            <textarea id="note" rows="3" name="note"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded border
                                border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            <x-input-error :messages="$errors->get('note')" class="mt-2" />
                        </div>
                        <!--  -->

                        @can('followUpDate', $type)
                            <div class="w-[20%] mt-4 hover:">
                                <label class="block mb-2 text-sm text-gray-900 font-semibold" for="note">
                                    {{ __('Next Follow Up Date') }}
                                </label>
                                <x-text-input name="next_follow_up_date" type="date" min="{{\Carbon\Carbon::today()->toDateString()}}" />
                                <x-input-error :messages="$errors->get('next_follow_up_date')" class="mt-2" />
                            </div>
                        @endcan
                        <!--  -->
                        <div class="gap-2 flex mt-6">
                            <a href=""
                                class="px-7 mb-4 py-3 bg-white text-black font-medium text-sm leading-snug border
                                rounded ripple-surface-light">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                class="px-7 mb-4 py-3 bg-slate-900 hover:bg-slate-600 text-white font-medium text-sm leading-snug
                                rounded shadow-md  hover:shadow-lg ripple-surface-light">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                </div>
                {{-- old notes --}}
                <div class="overflow-auto h-96">
                    <template x-for="(note, index) in notes">
                        <article class="bg-white m-auto w-full rounded-lg mt-4">
                            <h2 class="hidden"></h2>
                            <div class="shadow-sm p-3 text-sm leading-6 rounded border mb-4">
                                <div class="flex items-center gap-8 justify-between">
                                    <div>
                                        <p>
                                            <span class="font-bold">
                                                {{ __('Note : ') }}
                                            </span>
                                            <span x-text="note.note"></span>
                                        </p>
                                        @can('followUpDate', $type)
                                            <p>
                                                <span class="font-bold">
                                                    {{ __('Next Follow Up date : ') }}
                                                </span>

                                                <span x-text="formatDate(note.next_follow_up_date)" id="date"></span>
                                            </p>
                                        @endcan
                                        {{-- <p>
                                            <span class="font-bold">
                                                {{ __('Next Follow Up Date : ') }}
                                            </span>
                                            <span x-text="note.next_follow_up_date"></span>
                                            {{ dateFormat($note->next_follow_up_date) }}
                                        </p> --}}
                                    </div>
                                    {{-- Delete Confirmation Modal  --}}
                                    @can('isAdmin')
                                        <div class="inline-block" x-data="{ 'deleteModal': false }" x-cloak>
                                            <button type="button" id="userDeleteModal"
                                                @click="deleteModal = true,deleteNoteModal(index,note)"
                                                class="flex items-center gap-2">
                                                <svg class="w-4 h-4 " xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff0000"
                                                    aria-hidden="true">
                                                    <title>Delete</title>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0">
                                                    </path>
                                                    <title>{{ __('Delete') }}</title>
                                                </svg>
                                            </button>
                                            <input type="hidden" value="" id="userData" name="userData">
                                            <!-- Modal -->
                                            <div class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
                                                x-show="deleteModal" x-cloak>
                                                <!-- Modal inner -->
                                                <div class="max-w-3xl px-6 py-4 mx-auto text-left bg-white rounded shadow-lg "
                                                    @click.away="deleteModal = false"
                                                    x-transition:enter="motion-safe:ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 scale-90"
                                                    x-transition:enter-end="opacity-100 scale-100">
                                                    <!-- Title / Close-->
                                                    <div class="flex items-center justify-between">
                                                        <h5 class="mr-3 text-black font-medium max-w-none">Delete</h5>

                                                        <button type="button" class="z-50 cursor-pointer"
                                                            @click="deleteModal = false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <!-- content -->
                                                    <div>
                                                        <p class="text-lg mt-4">Are you sure you want to remove this note ?
                                                        </p>
                                                        <div class="flex justify-content-end gap-4 mt-6">
                                                            <button @click ="deleteModal =false"
                                                                class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 mb-3">{{ 'Cancel' }}
                                                            </button>
                                                            <form action="" method="post"
                                                                x-bind:id="`delete_${index}_note`">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit"
                                                                    class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 mb-3 cursor-pointer">{{ 'Yes, Delete!' }}
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                </div>
                                <div class="flex justify-between gap-4 mt-3">
                                    <div class="flex">
                                        <div class="text-gray-400"> {{ __('Created by:') }}</div>
                                        <div class="ml-2">
                                            <template x-if="note.created_by">
                                                <span x-text="note.created_by.user_profile.first_name"></span>
                                            </template>
                                            {{-- {{ $note->createdBy->userProfile->fullName }} --}}
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <div class="text-gray-400">{{ __('Date:') }}</div>
                                        <div class="ml-2" x-text="note.created_at">
                                            {{-- {{ dateFormat($note->created_at) }} --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </template>
                </div>
            </section>
        </section>
        <script>
            function notes() {
                return {
                    notes: null,
                    open: false,
                    authRole: @js(Auth::user()->role->name),
                    openModal(url, data) {
                        var form = document.querySelector('#add_note');
                        form.action = url;
                        this.notes = data;
                    },
                    deleteNoteModal(index, note) {
                        var form = document.querySelector(`#delete_${index}_note`);
                        url = @js(url('/'));
                        var deleteUrl = `${url}/${this.authRole}/members/${note.id}/notes/delete`;
                        form.action = deleteUrl;
                    }
                }
            }
        </script>
        <script>
            function formatDate(dateString) {
                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                const date = new Date(dateString);
                const formattedDate = date.toLocaleDateString('en-GB', options); // Use 'en-GB' for day-month-year format
                return formattedDate.replace(',', '').replace(/\s+/g, '-'); // Replace space with hyphen
            }
        </script>

    </div>
</x-modal>
