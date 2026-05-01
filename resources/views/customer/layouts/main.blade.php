<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Elite Edge | Gym and Spa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/pikaday.min.css') }}">
    <!-- Include Moment.js (required for Pikaday) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="{{ asset('js/pikaday.min.js') }}"></script>
    @include('partials.brand-theme')
</head>

<body>
    <aside>
        @include('customer.layouts.sidebar')
    </aside>
    <header>
        @include('customer.layouts.header')
    </header>
    <main class="flex-1 flex-col flex py-16 md:pl-48  bg-gray-200 min-h-screen">
        @stack('breadcrum')
        @yield('main-section')
    </main>
    <footer class="fixed bottom-0 inset-x-0 pl-44 bg-white z-10">
        @include('customer.layouts.footer')
    </footer>
    @stack('script')
</body>

</html>
