@props(['one', 'three', 'six', 'twelve', 'male', 'female'])

<!-- Popup Trigger -->
<div>
    <span id="info-icon">
        <svg class="w-8 h-8 cursor-pointer ml-5 inline-block mt-1 rounded-md bg-orange-100 px-2 py-1 text-xs font-medium text-orange-600 ring-1 ring-inset ring-orange-600/70 hover:scale-105" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            version="1.1" viewBox="0 0 16 16" fill="currentColor">
            <path fill="currentColor" d="M5 11h3v5h-3v-5z"></path>
            <path fill="currentColor" d="M1 14h3v2h-3v-2z"></path>
            <path fill="currentColor" d="M13 12h3v4h-3v-4z"></path>
            <path fill="currentColor" d="M9 9h3v7h-3v-7z"></path>
            <path fill="currentColor"
                d="M5 0c-2.761 0-5 2.239-5 5s2.239 5 5 5c2.761 0 5-2.239 5-5s-2.239-5-5-5zM5 9c-2.209 0-4-1.791-4-4s1.791-4 4-4v4h4c0 2.209-1.791 4-4 4z">
            </path>
        </svg>
    </span>
</div>

<!-- Popup Modal -->
<div id="popup" class="hidden fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-75">
    <div class="relative bg-white border border-gray-300 rounded-lg shadow-lg p-6 max-w-3xl m-auto lg:w-full">
        <!-- Close Icon -->
        <span class="block mb-4">
            <svg id="close-popup" class="h-7 w-7 text-red-500 cursor-pointer absolute top-4 right-4" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </span>

        <!-- Modal Content -->
        <h2 class="text-xl font-bold text-orange-500 text-center mb-4">Membership & Active Users</h2>
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- First Partition: Membership Details -->
            <div class="w-full">
                <h3 class="text-base font-semibold text-orange-500 mb-2 text-center">Membership Data</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-sm">
                        <thead>
                            <tr class="bg-orange-500 text-white text-sm uppercase tracking-wider">
                                <th class="py-3 px-5 border-b text-left">Plans</th>
                                <th class="py-3 px-5 border-b text-left">Users</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            <tr class="hover:bg-orange-100 transition-colors">
                                <td class="py-3 px-5 border-b">
                                    <!-- <a href="{{ route(auth()->user()->roleName . 'user.index', ['orderby' => 4 ,'plan_key'=>12 ]) }}" class="text-orange-500 hover:underline"> -->
                                        12 Month Plans
                                    <!-- </a> -->
                                </td>
                                <td class="py-3 px-5 border-b">{{ $twelve }}</td>
                            </tr>
                            <tr class="hover:bg-orange-100 transition-colors">
                                <td class="py-3 px-5 border-b">
                                    <!-- <a href="{{ route(auth()->user()->roleName . 'user.index', ['orderby' => 4 ,'plan_key'=>4 ]) }}" class="text-orange-500 hover:underline"> -->
                                    6 Month Plans
                                    <!-- </a> -->
                                </td>
                                <td class="py-3 px-5 border-b">{{ $six }}</td>
                            </tr>
                            <tr class="hover:bg-orange-100 transition-colors">
                                <td class="py-3 px-5 border-b">
                                    <!-- <a href="{{ route(auth()->user()->roleName . 'user.index', ['orderby' => 4 ,'plan_key'=>3 ]) }}" class="text-orange-500 hover:underline"> -->
                                    3 Month Plans
                                    <!-- </a> -->
                                </td>
                                <td class="py-3 px-5 border-b">{{ $three }}</td>
                            </tr>
                            <tr class="hover:bg-orange-100 transition-colors">
                                <td class="py-3 px-5 border-b">
                                    <!-- <a href="{{ route(auth()->user()->roleName . 'user.index', ['orderby' => 4 ,'plan_key'=>1 ]) }}" class="text-orange-500 hover:underline"> -->
                                    1 Month Plans
                                    <!-- </a> -->
                                </td>
                                <td class="py-3 px-5 border-b">{{ $one }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Second Partition: Active Users Graph -->
            <div class="w-full">
                <h3 class="text-base font-semibold text-orange-500 mb-2 text-center">Active Male & Female</h3>
                <div>
                    <x-active-user-count :male="$male" :female="$female" />
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('info-icon').addEventListener('click', function() {
        document.getElementById('popup').classList.toggle('hidden');
    });

    document.getElementById('close-popup').addEventListener('click', function() {
        document.getElementById('popup').classList.add('hidden');
    });
    //click anywhere to close
    document.getElementById('popup').addEventListener('click', function(event) {
        if (event.target == this) {
            document.getElementById('popup').classList.add('hidden');
        }
    })
</script>