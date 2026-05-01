<header class="bg-white shadow top-0 text-black w-full z-50 inset-x-0 fixed" x-data="{ mobilemenue: false }">
    <div class="mx-auto">
        <div class="flex flex-row-reverse md:flex-row items-stretch justify-between h-16 px-4 md:px-0">
            <div class="flex items-center md:hidden">
                <div class="-mr-2 flex" x-data>
                    <!-- Mobile menu button -->
                    <button type="button" @click="$dispatch('togglemenubar')"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>

                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>

                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route(auth()->user()->roleName . 'dashboard') }}"
                        class="text-white flex items-center space-x-2 group ml-5">
                        <x-website-logo />
                    </a>
                </div>

                {{-- <!-- toggel sidebar -->
                <div class="text-white cursor-pointer hidden md:block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </div> --}}
            </div>
            <div class="hidden md:flex flex-1 items-center px-6" x-data="memberSearch()">
                <div class="relative w-full max-w-2xl mx-auto py-2" @click.outside="open = false">
                    <div
                        class="flex items-center gap-3 rounded-xl border border-slate-400 bg-white px-4   text-white   ">
                        <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m21 21-4.35-4.35m1.85-5.15a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                        </svg>
                        <input type="search" x-model="query" @input.debounce.300ms="fetchMembers()"
                            placeholder="Search - Member | Enquiry"
                            class="w-full border-0 bg-transparent text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-0" />
                    </div>

                    <div x-cloak x-show="open" x-transition
                        class="absolute left-0 right-0 top-full z-50 mt-3 h-[32rem] overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl">
                        <template x-if="loading">
                            <div class="flex items-center gap-3 px-5 py-4 text-sm font-medium text-slate-600">
                                <svg class="h-4 w-4 animate-spin text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 0 1 4 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Searching member...
                            </div>
                        </template>

                        <template x-if="!loading && results.length === 0">
                            <div class="px-5 py-4 text-sm text-slate-500">No member found.</div>
                        </template>

                        <div class="h-[calc(32rem-3.5rem)] overflow-y-auto">
                            <template x-for="member in results" :key="member.id">
                                <a :href="member.view_url"
                                    class="flex min-h-[14rem] items-stretch gap-4 border-b border-slate-100 p-4 transition hover:bg-slate-50 last:border-b-0">
                                    <div class="flex w-40 flex-col items-center justify-center border-r border-slate-100 pr-4">
                                        <div
                                            class="flex h-24 w-24 items-center justify-center overflow-hidden rounded-full border border-slate-200 bg-slate-100">
                                            <img :src="member.image_url || defaultAvatar" alt="Member"
                                                class="h-full w-full object-cover">
                                        </div>
                                        <div class="mt-3 text-center">
                                            <div class="text-lg font-semibold text-slate-800" x-text="member.full_name"></div>
                                            <div class="mt-1 text-sm text-slate-500">
                                                Code: <span x-text="member.member_id"></span>
                                            </div>
                                            <div class="text-sm text-slate-500" x-text="member.phone"></div>
                                        </div>
                                    </div>

                                    <div class="min-w-0 flex-1 rounded-2xl border-l-4 border-amber-500 bg-slate-50 p-4">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <div class="text-lg font-semibold text-slate-800" x-text="member.membership_name || 'Membership'"></div>
                                                <div class="mt-3 space-y-2 text-sm text-slate-600">
                                                    <div>Start: <span x-text="member.start_date || '-'" ></span></div>
                                                    <div>End: <span x-text="member.end_date || '-'" ></span></div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xl font-bold text-emerald-600"
                                                    x-text="member.membership_amount ? '₹' + member.membership_amount : '₹0'"></div>
                                                <div class="mt-10 text-sm font-semibold uppercase tracking-wide text-slate-900"
                                                    x-text="member.status"></div>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex items-center justify-between text-sm">
                                            <div class="text-slate-600">
                                                Balance:
                                                <span class="font-semibold text-red-500"
                                                    x-text="member.remaining_amount ? '₹' + member.remaining_amount : '₹0'"></span>
                                            </div>
                                            <div class="text-xs font-medium text-slate-400">
                                                Tap to open member profile
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden md:flex items-stretch">
                <!-- Profile Menu DT -->
                <div class="ml-4 flex md:ml-6 ">
                    <!-- Profile dropdown -->
                    <div class="relative bg-white px-4 text-black text-sm cursor-pointer" x-data="{ open: false }">
                        <div class="flex items-center min-h-full" @click="open = !open">
                            <img src="{{ profileImage(auth()->user()->image->path) }}" alt=""
                                class="rounded-full w-10 h-10">
                            <div class="flex  gap-2 items-center ml-4">
                                <span>{{ __(auth()->user()->userProfile->fullName) }}</span>
                                <span>
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490 480"
                                        fill="currentColor">
                                        <title>down</title>
                                        <path d="M250 360l180-180-30-30-150 150-160-150-30 30 190 180z"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div x-show="open" x-cloak @click.away="open = false"
                            class="z-50 origin-top-right absolute right-1 mt-0 min-w-full rounded-b-md shadow py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none border"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95" role="menu"
                            aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="{{ route(auth()->user()->roleName . 'profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                tabindex="-1" id="user-menu-item-0">
                                {{ __('My Profile') }}
                            </a>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>

@push('script')
<script>
    function memberSearch() {
        return {
            query: '',
            results: [],
            loading: false,
            open: false,
            timer: null,
            defaultAvatar: "{{ asset('images/default-avatar.svg') }}",
            async fetchMembers() {
                const search = this.query.trim();

                if (!search) {
                    this.results = [];
                    this.open = false;
                    return;
                }

                clearTimeout(this.timer);
                this.timer = setTimeout(async () => {
                    this.loading = true;
                    this.open = true;

                    try {
                        const url = "{{ route(auth()->user()->roleName . 'user.search') }}?search=" + encodeURIComponent(search);
                        const response = await fetch(url, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        const payload = await response.json();
                        this.results = payload.data ?? [];
                        this.open = true;
                    } catch (error) {
                        this.results = [];
                        this.open = true;
                    } finally {
                        this.loading = false;
                    }
                }, 200);
            }
        }
    }
</script>
@endpush
