@once
<style>
    :root {
        --brand: #F76914;
        --brand-50: #FFF1E8;
        --brand-100: #FFE4D4;
        --brand-200: #FFC9A8;
        --brand-300: #FFAB78;
        --brand-400: #FF8B47;
        --brand-500: #F76914;
        --brand-600: #DE5D11;
        --brand-700: #C7510F;
        --brand-800: #A9450D;
        --brand-900: #87370A;
    }

    .bg-orange-50 { background-color: var(--brand-50) !important; }
    .bg-orange-100 { background-color: var(--brand-100) !important; }
    .bg-orange-200 { background-color: var(--brand-200) !important; }
    .bg-orange-300 { background-color: var(--brand-300) !important; }
    .bg-orange-400 { background-color: var(--brand-400) !important; }
    .bg-orange-500 { background-color: var(--brand-500) !important; }
    .bg-orange-600 { background-color: var(--brand) !important; }
    .bg-orange-700 { background-color: var(--brand-700) !important; }
    .bg-orange-800 { background-color: var(--brand-800) !important; }
    .bg-orange-900 { background-color: var(--brand-900) !important; }

    .text-orange-50 { color: var(--brand-50) !important; }
    .text-orange-100 { color: var(--brand-100) !important; }
    .text-orange-200 { color: var(--brand-200) !important; }
    .text-orange-300 { color: var(--brand-300) !important; }
    .text-orange-400 { color: var(--brand-400) !important; }
    .text-orange-500 { color: var(--brand-500) !important; }
    .text-orange-600 { color: var(--brand) !important; }
    .text-orange-700 { color: var(--brand-700) !important; }
    .text-orange-800 { color: var(--brand-800) !important; }
    .text-orange-900 { color: var(--brand-900) !important; }

    .border-orange-50 { border-color: var(--brand-50) !important; }
    .border-orange-100 { border-color: var(--brand-100) !important; }
    .border-orange-200 { border-color: var(--brand-200) !important; }
    .border-orange-300 { border-color: var(--brand-300) !important; }
    .border-orange-400 { border-color: var(--brand-400) !important; }
    .border-orange-500 { border-color: var(--brand-500) !important; }
    .border-orange-600 { border-color: var(--brand) !important; }
    .border-orange-700 { border-color: var(--brand-700) !important; }
    .border-orange-800 { border-color: var(--brand-800) !important; }
    .border-orange-900 { border-color: var(--brand-900) !important; }

    .hover\:bg-orange-50:hover { background-color: var(--brand-50) !important; }
    .hover\:bg-orange-100:hover { background-color: var(--brand-100) !important; }
    .hover\:bg-orange-200:hover { background-color: var(--brand-200) !important; }
    .hover\:bg-orange-300:hover { background-color: var(--brand-300) !important; }
    .hover\:bg-orange-400:hover { background-color: var(--brand-400) !important; }
    .hover\:bg-orange-500:hover { background-color: var(--brand-600) !important; }
    .hover\:bg-orange-600:hover { background-color: var(--brand-700) !important; }
    .hover\:bg-orange-700:hover { background-color: var(--brand-800) !important; }
    .hover\:bg-orange-800:hover { background-color: var(--brand-900) !important; }

    .hover\:text-orange-500:hover { color: var(--brand-500) !important; }
    .hover\:text-orange-600:hover { color: var(--brand) !important; }
    .hover\:text-orange-700:hover { color: var(--brand-700) !important; }
    .hover\:text-orange-800:hover { color: var(--brand-800) !important; }
    .hover\:border-orange-600:hover { border-color: var(--brand) !important; }

    .focus\:border-orange-600:focus { border-color: var(--brand) !important; }
    .focus\:ring-orange-300:focus { --tw-ring-color: var(--brand-300) !important; }
    .focus\:ring-orange-600:focus { --tw-ring-color: var(--brand) !important; }
    .focus-visible\:outline-orange-500:focus-visible { outline-color: var(--brand) !important; }
    .focus-visible\:outline-orange-600:focus-visible { outline-color: var(--brand) !important; }
    .ring-orange-600 { --tw-ring-color: var(--brand) !important; }
    .ring-orange-600\/70 { --tw-ring-color: rgb(247 105 20 / 0.7) !important; }

    .bg-brand { background-color: var(--brand) !important; }
    .text-brand { color: var(--brand) !important; }
    .border-brand { border-color: var(--brand) !important; }
    .hover\:bg-brand-700:hover { background-color: var(--brand-600) !important; }
    .focus\:ring-brand:focus { --tw-ring-color: var(--brand) !important; }
    .focus-visible\:outline-brand:focus-visible { outline-color: var(--brand) !important; }

    .bg-blue-300 { background-color: var(--brand-100) !important; }
    .bg-blue-400 { background-color: var(--brand-300) !important; }
    .bg-blue-500 { background-color: var(--brand-500) !important; }
    .bg-blue-600 { background-color: var(--brand-700) !important; }
    .text-blue-500 { color: var(--brand-500) !important; }
    .border-blue-400 { border-color: var(--brand-300) !important; }
    .border-blue-500 { border-color: var(--brand-500) !important; }
    .hover\:bg-blue-600:hover { background-color: var(--brand-700) !important; }
    .hover\:text-blue-500:hover { color: var(--brand-500) !important; }
    .focus\:ring-blue-500:focus { --tw-ring-color: var(--brand) !important; }
    .focus\:ring-blue-400:focus { --tw-ring-color: var(--brand-400) !important; }
    .from-blue-300 { --tw-gradient-from: var(--brand-100) var(--tw-gradient-from-position); --tw-gradient-to: rgb(255 228 212 / 0) var(--tw-gradient-to-position); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }
    .to-blue-600 { --tw-gradient-to: var(--brand-700) var(--tw-gradient-to-position); }

    [x-cloak] { display: none !important; }
</style>
@endonce
