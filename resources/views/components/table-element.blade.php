<div class="bg-white p-4 rounded-lg">
    <div class="sm:rounded-lg h-full overflow-auto min-h-[35vh]">
        <table {{ $attributes->merge([
            'class' => 'min-w-full divide-y divide-gray-300 bg-white',
        ]) }}>
            {{ $slot }}
        </table>
    </div>
</div>

