<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('EliteEdge Gym and Spa') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/pikaday.min.css') }}">
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="{{ asset('js/pikaday.min.js') }}"></script>
    <script src="{{ asset('js/razorpay.min.js') }}"></script>
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
        @include('partials.brand-theme')

</head>
<body>
    {{ $slot }}
</body>
</html>
