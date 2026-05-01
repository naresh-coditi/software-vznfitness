@props(['user' => null])
<section class="w-full px-6 mt-2 py-6 fixed inset-0 backdrop-grayscale bg-black/30 transition-opacity z-50" x-show="open"
    x-cloak>
    {{-- New Comment --}}
    <div class="bg-white xl:w-2/3 m-auto w-full rounded-lg p-6 relative">
        <button class="absolute right-4" @click="open = false">
            <svg class="w-12 h-12" width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M6.75827 17.2426L12.0009 12M17.2435 6.75736L12.0009 12M12.0009 12L6.75827 6.75736M12.0009 12L17.2435 17.2426"
                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
        {{-- <form action="{{ route(auth()->user()->roleName . 'lead.notes.store', $user) }}" method="post" class="gap-2">
            @csrf
            <div class="w-full">
                <label class="block mb-2 text-sm text-gray-900 font-semibold" for="note">
                    {{ __('Enter Note') }}
                </label>
                <textarea id="note" rows="3" name="note"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded border
                        border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                <x-input-error :messages="$errors->get('note')" class="mt-2" />
            </div>
            <div class="w-full mt-4">
                <label class="block mb-2 text-sm text-gray-900 font-semibold" for="note">
                    {{ __('Next Follow Up Date') }}
                </label>
                <x-text-input name="next_follow_up_date" type="date" />
                <x-input-error :messages="$errors->get('next_follow_up_date')" class="mt-2" />
            </div>
            <div class="gap-2 flex mt-6">
                <a href="{{ route(auth()->user()->roleName . 'lead.index') }}"
                    class="px-7 mb-4 py-3 bg-white text-black font-medium text-sm leading-snug border
                        rounded ripple-surface-light">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" x-bind:disabled="disable"
                    class="px-7 mb-4 py-3 bg-orange-600 hover:bg-orange-500 text-white font-medium text-sm leading-snug
                        rounded shadow-md  hover:shadow-lg ripple-surface-light">
                    {{ __('Submit') }}
                </button>
            </div>
        </form> --}}
    </div>
    {{-- old notes --}}
    {{-- @forelse ($user->notes as $note) --}}
    <template x-if="open">
        <template x-for="(note,index) in notes">
            <article class="bg-white xl:w-2/3 m-auto w-full rounded-lg p-6 mt-9">
                <h2 class="hidden"></h2>
                <div class="shadow-sm p-3 text-sm leading-6 rounded border mb-4">
                    <div class="flex items-center gap-8 justify-between">
                        <div>
                            <p>
                                <span class="font-bold">
                                    {{ __('Note : ') }}
                                </span>
                                <span x-text="note.note"></span>
                                {{-- {{ $note->note }} --}}
                            </p>
                            <p>
                                <span class="font-bold">
                                    {{ __('Next Follow Up Date : ') }}
                                </span>
                                <span x-text="note.next_follow_up_date">
                                </span>
                                {{-- {{ dateFormat($note->next_follow_up_date) }} --}}
                            </p>
                        </div>
                        {{-- Delete Confirmation Modal  --}}
                        {{-- <x-delete-confirmation-modal :values="$user" :message="'Are you sure you want to remove this note ?'" routename="{{ route(auth()->user()->roleName . 'lead.notes.delete', $note) }}" /> --}}
                    </div>
                    <div class="flex justify-between gap-4 mt-3">
                        <div class="flex">
                            <div class="text-gray-400"> {{ __('Created by:') }}</div>
                            <div class="ml-2"
                                x-text="note.created_by.user_profile.first_name +' '+ note.created_by.user_profile.last_name">
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
    </template>
    {{-- @empty
        <article class="bg-white xl:w-2/3 m-auto w-full rounded-lg p-6 mt-9">
            <h2>{{ __('No Record Found') }}</h2>
        </article>
    @endforelse --}}
</section>
