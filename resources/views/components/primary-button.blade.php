<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'rounded bg-brand px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand']) }}>
    {{ $slot }}
</button>
