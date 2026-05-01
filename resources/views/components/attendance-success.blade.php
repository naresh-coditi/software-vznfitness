<div class="fixed inset-0 bg-gray-900 bg-opacity-50 w-screen h-screen flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96 text-center" @click.away="hidden">
        <!-- Profile Image with Thick Border -->
        <div class="relative mx-auto w-32 h-32">
            <img src="https://via.placeholder.com/150" alt="User Image"
                class="w-full h-full rounded-full border-4 border-green-500">
        </div>
        <!-- User Details -->
        <div class="mt-4">
            <h1 class="text-xl font-bold text-gray-800">John Doe</h1>
            <p class="text-gray-600">Attendance Marked Successfully</p>
        </div>
    </div>
</div>
