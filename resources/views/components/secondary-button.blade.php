<button {{ $attributes->merge(['type' => 'button', 'class' => 'rounded-md bg-white px-6 py-2 text-sm font-semibold text-black shadow-sm border']) }}>
    {{ $slot }}
</button>
