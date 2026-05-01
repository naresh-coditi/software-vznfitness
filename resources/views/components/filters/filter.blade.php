<div>
    <!-- Button to open the filter panel -->
    <button onclick="toggleFilterPanel()"
        class="flex items-center justify-center h-12 w-12 bg-orange-500 rounded-full text-white hover:bg-orange-600 transition-all duration-300 ease-in-out shadow-lg transform hover:scale-105"
        aria-label="Open Filters">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
        </svg>
    </button>

    <!-- Full-screen filter panel -->
    <div id="filterPanel"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 transition-opacity duration-300 ease-in-out">
        <div id="panelContent"
            class="bg-white w-96 h-full p-6 overflow-y-auto shadow-2xl absolute right-0 top-0 transform translate-x-full transition-transform duration-500 ease-in-out animate-slide-in">
            <button onclick="toggleFilterPanel()"
                class="text-orange-500 hover:text-orange-600 font-semibold mb-4 transition duration-200 ease-in-out">
                <svg class="h-8 w-8 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 8 8 12 12 16" />
                    <line x1="16" y1="12" x2="8" y2="12" />
                </svg>
            </button>
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Filter Options</h2>
            <form action="" method="get">

                {{ $slot }}

                <!-- Apply Filters Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-orange-500 text-white py-3 rounded-md hover:bg-orange-600 transition-all duration-300 ease-in-out transform hover:scale-105 shadow-lg">Apply
                        Filters
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleFilterPanel() {
        const panel = document.getElementById('filterPanel');
        const panelContent = document.getElementById('panelContent');

        // Toggle visibility
        panel.classList.toggle('hidden');

        // Add slide-in/out effect
        if (panel.classList.contains('hidden')) {
            panelContent.classList.add('translate-x-full');
            panelContent.classList.remove('animate-slide-in');
        } else {
            panelContent.classList.remove('translate-x-full');
            panelContent.classList.add('animate-slide-in');
        }

        panel.classList.toggle('opacity-0');
        panel.classList.toggle('opacity-100');
    }

    document.getElementById('filterPanel').addEventListener('click', function(event) {
        if (event.target === this) {
            toggleFilterPanel();
        }
    });
</script>

<style>
    #filterPanel {
        opacity: 0;
    }

    #filterPanel:not(.hidden) {
        opacity: 1;
    }

    /* Keyframes for the slide-in animation */
    @keyframes slide-in {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(0);
        }
    }

    /* animation */
    .animate-slide-in {
        animation: slide-in 0.5s ease-in-out forwards;
    }
</style>
