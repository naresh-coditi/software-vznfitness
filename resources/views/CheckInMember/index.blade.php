<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Check In') }}</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <meta property="og:image" content="{{ asset('images/cover/460888.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            height: 100vh;
            padding: 2rem;
            margin-top: 25%;
            margin-right: 4%;
            box-sizing: border-box;
        }

        .text-section {
            flex: 1;
            max-width: 60%;
        }

        .form-section {
            flex: 1;
            max-width: 35%;
        }

        /* Added styling for video and canvas */
        video,
        canvas {
            display: block;
            margin: 10px auto;
            width: 100%;
            /* Make it responsive */
        }
    </style>
    @include('partials.brand-theme')
</head>

<body class="bg-gradient-to-r from-blue-300 to-blue-600 flex items-center justify-center h-screen" style="background-image: url('images/cover/460888.jpg'); background-size: cover; background-position: center;">
    @include('CheckInMember.layouts.header')

    {{-- @if(session('checkProfile'))
   <div class="fixed inset-0 z-50">
        <x-attendance-success />
    </div> 
    @endif   --}}

    <div class="flex flex-col xl:flex-row justify-between items-center gap-6 w-full md:px-12">
        <!-- Text Section -->
        <div class="text-center text-white w-full hidden md:block">
            <h1 id="dynamic-heading" class="text-6xl font-extrabold mb-4 text-blue-500"></h1>
            <p id="dynamic-paragraph" class="xl:text-4xl text-3xl mb-6 leading-8 "></p>
        </div>

        <!-- Form Section -->
        <div class="lg:w-1/2 flex justify-center">
            <div class="bg-white bg-opacity-5 backdrop-filter backdrop-blur-lg border border-white border-opacity-25 rounded-lg shadow-lg p-8 fade-in w-3/4">

                <h1 class="text-2xl font-semibold text-center text-white mb-6">Mark Attendance</h1>

                <form action="{{ route('checkin.mark') }}" method="POST">
                    @csrf
                    <input type="text" name="id" placeholder="Enter your Member ID" required
                        class="border border-blue-400 rounded-md p-3 w-full mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <input type="phone" name="number" placeholder="Enter your Phone Number" required
                        class="border border-blue-400 rounded-md p-3 w-full mb-1 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <x-input-error :messages="$errors->get('number')" />
                    <span class="flex justify-between">
                        <span class="m-3">
                            <input type="radio" name="time" id="morning" value="morning"
                                class="text-blue-500 focus:ring-blue-500 rounded-md mr-2" required>
                            <label for="morning" class="text-white">Morning</label>
                        </span>
                        <span class="m-3">
                            <input type="radio" name="time" id="evening" value="evening"
                                class="text-blue-500 focus:ring-blue-500 rounded-md mr-2" required>
                            <label for="evening" class="text-white">Evening</label>
                        </span>
                    </span>

                    <button type="submit"
                        class="w-full bg-blue-500 text-white rounded-md mt-4 py-2 hover:bg-orange-600 shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-200">
                        Check In
                    </button>
                </form>

                {{-- <div class="flex items-center justify-center gap-6 mt-4 text-gray-600 text-sm">
                    <a href="{{ route('dashboard') }}" class="block text-white">
                &copy; Elite Edge Gym
                </a>
                <a href="{{ route('login') }}" class="text-white hover:text-blue-500">
                    Login Page
                </a>
            </div> --}}
        </div>
    </div>
    </div>
    <script src="{{ asset('js/CheckInJS/main.js') }}"></script>
</body>

</html>