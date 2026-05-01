@props(['staff'])
<div id="staff-login-popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 max-h-[70vh] w-[30%] overflow-auto relative">
        <h2 class="text-xl font-semibold mb-4 text-center">Staff Members</h2>
        <div class="space-y-2">
            @foreach ($staff as $profile)
                <a href="#" class="block text-blue-600 hover:underline">
                    {{ $profile->userProfile->first_name }} {{ $profile->userProfile->last_name }}
                </a>
            @endforeach
        </div>
        <svg id="close-popup" class="absolute top-4 right-4 h-6 w-6 text-gray-500 cursor-pointer hover:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popup = document.getElementById('staff-login-popup');
        const closeButton = document.getElementById('close-popup');

        // Show the popup (you can customize this to trigger based on your needs)
        popup.classList.remove('hidden');

        closeButton.addEventListener('click', () => {
            // Reload the page when the close button is clicked
            location.reload();
        });

        window.addEventListener('click', (e) => {
            if (e.target === popup) {
                popup.classList.add('hidden');
            }
        });
    });
</script>
