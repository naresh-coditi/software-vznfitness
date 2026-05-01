@props(['plans'])

<div id="staff-login-popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-20">
    <div class="bg-white rounded-lg shadow-lg p-6 max-h-[80vh] overflow-auto relative w-11/12 md:w-3/4 lg:w-1/2">
        <!-- Close Icon -->
        <svg id="close-popup" class="h-8 w-8 text-red-500 cursor-pointer absolute top-4 right-4 transition-transform transform hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
        </svg>

        <h2 class="text-xl font-semibold mb-4 text-center">Welcome, Staff Member!</h2>
        <h3 class="mb-4 text-lg font-semibold text-center">Upcoming Renewals for Next 15 Days</h3>

        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead class="bg-gray-200">
                <tr class="text-left">
                    @foreach(['ID', 'Name', 'Membership', 'Amount', 'Remaining Balance', 'Start Date', 'Expiring Date'] as $header)
                        <th class="py-3 px-4 border-b text-gray-700 font-medium">{{ __($header) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                    <tr class="bg-red-100 hover:bg-red-200 transition-colors duration-300">
                        <td class="py-2 px-4 border-b">{{ $plan->user->member_id }}</td>
                        <td class="py-2 px-4 border-b">{{ $plan->userProfile->fullName }}</td>
                        <td class="py-2 px-4 border-b">{{ $plan->name ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ $plan->amount ? '₹' . number_format($plan->amount, 2) : '₹ 0.00' }}</td>
                        <td class="py-2 px-4 border-b">{{ $plan->remaining_amount ? '₹' . number_format($plan->remaining_amount, 2) : '₹ 0.00' }}</td>
                        <td class="py-2 px-4 border-b">{{ dateFormat($plan->start_date) }}</td>
                        <td class="py-2 px-4 border-b">{{ dateFormat($plan->end_date) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-gray-500">No Upcoming Renewals</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popup = document.getElementById('staff-login-popup');
        const closeButton = document.getElementById('close-popup');

        popup.classList.remove('hidden');

        closeButton.addEventListener('click', () => {
            popup.classList.add('hidden');
        });

        window.addEventListener('click', (e) => {
            if (e.target === popup) {
                popup.classList.add('hidden');
            }
        });
    });
</script>

<style>
    /* Custom Scrollbar Styles */
    ::-webkit-scrollbar {
        width: 12px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    .scrollable {
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }
</style>
