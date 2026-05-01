<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/datepicker.min.js') }}"></script>
    <script src="{{ asset('js/chartjs.um.min.js') }}"></script>
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <script src="{{ asset('js/choicejs.min.js') }}"></script>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('css/choicesjs.min.css') }}">

    @stack('title')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.brand-theme')
</head>

<body>
    <!-- sidebar -->
    @include('admin.layouts.sidebar')
    <!-- End sidebar -->
    <main>
        <!-- content -->
        <section class="flex-1 flex-col flex md:pl-52 bg-slate-100 min-h-screen">
            <!-- Header -->
            @include('admin.layouts.header')
            <!-- End header -->
            <section class="mb-auto flex-grow pb-8 pt-20 px-6">
                <!-- Breadcrum -->
                @stack('breadcrum')
                <!-- Main section content -->
                @yield('main-section')
            </section>
            <!-- Footer -->
            <!-- @include('admin.layouts.footer') -->
        </section>
    </main>
    @stack('script')
    {{-- <script>

            const input = document.querySelector("#phone");
  window.intlTelInput(input, {
    initialCountry: "in",
    onlyCountries: ["in"],


    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/js/utils.js",
  });


    </script> --}}
</body>

</html>
