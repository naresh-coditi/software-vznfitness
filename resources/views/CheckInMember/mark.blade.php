<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @push('title')
    <title>{{ __('Check In') }}</title>
    @endpush
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

        video,
        canvas {
            display: block;
            margin: 10px auto;
            width: 100%;
        }
    </style>
    @include('partials.brand-theme')
</head>

<body class="bg-gradient-to-r from-blue-300 to-blue-600 flex items-center justify-center h-screen"
    style="background-image: url('images/cover/5958326.jpg'); background-size: cover; background-position: center;">
    @include('CheckInMember.layouts.header')

    <div class="flex flex-col xl:flex-row justify-between items-center gap-6 w-full px-12">
        <div id="heading-content" class="text-center text-white w-full hidden md:block">
            <h1 id="dynamic-heading" class="text-6xl font-extrabold mb-4 text-blue-500"></h1>
            <p id="dynamic-paragraph" class="xl:text-4xl text-3xl mb-6 leading-8"></p>
        </div>

        <div class="lg:w-1/2 h-full flex flex-col items-center">
            <div
                class="bg-white bg-opacity-5 backdrop-filter backdrop-blur-lg border border-white border-opacity-20 rounded-lg shadow-lg p-8 fade-in w-3/4">
                @if ($user->image->path == null)
                <h1 class="text-2xl font-semibold text-center text-white mb-6">
                    <label for="profile_picture" id="content" class="text-white"></label>
                </h1>
                @endif
                <!-- Profile Image Section -->
                @if ($user->image->path != null)
                <div
                    class="profile mx-auto mb-6 w-36 h-36 bg-gray-300 rounded-full overflow-hidden flex items-center justify-center">
                    <img id="profile-image-preview" src="{{ profileImage($user->image->path) }}"
                        alt="Profile Picture" class="w-full h-full object-cover">
                </div>
                @endif

                <form action="{{ route('checkin.store', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="id" placeholder="Enter your ID" value="{{ $user->member_id }}"
                        required
                        class="border border-blue-400 rounded-md p-3 w-full mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition hidden">
                    <input type="phone" name="number" placeholder="Enter your Phone Number"
                        value="{{ $user->phone }}" required
                        class="border border-blue-400 rounded-md p-3 w-full mb-1 focus:outline-none focus:ring-2 focus:ring-blue-500 transition hidden">
                    <x-input-error :messages="$errors->get('number')" />

                    <!-- Webcam Capture Section -->
                    @if ($user->image->path == null)
                    <div class="mb-4 text-center">
                        <div class="flex justify-center flex-row mt-3">

                            <label for="profile_picture" id="ok" class="ml-2 hidden"><svg
                                    class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></label>
                        </div>


                        <video id="video" name="video" class="rounded-lg shadow-md w-full"
                            style="display:none;"></video>
                        <canvas id="canvas" style="display:none;"></canvas>
                        <button type="button" id="take-picture-btn"
                            class="w-1/2 bg-blue-500 text-white rounded-md mt-1 py-2 hover:bg-blue-600 shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-200">
                            Take Picture
                        </button>
                        <button type="button" id="capture-btn"
                            class="w-1/2 bg-blue-500 text-white rounded-md mt-1 py-2 hover:bg-blue-600 shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-200"
                            style="display:none;">
                            Capture Image
                        </button>
                        <input type="hidden" name="profile_picture" id="profile-picture">
                        <x-input-error :messages="$errors->get('video')" />
                        <p id="video-error" class="text-sm text-red-600 pt-2"></p>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <button type="submit" id="uploadButton"
                            class="w-full bg-blue-500 text-white rounded-md mt-2 py-2 hover:bg-blue-600 shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-200 hidden">
                            Upload Profile
                        </button>
                    </div>

                </form>
                <div class="flex justify-center">
                    <a href="{{ route('checkin.index') }}"><button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-transform transform hover:scale-105 duration-200 shadow-md">
                        Cancel
                    </button></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Webcam Capture Script -->
    <script>
        const video = document.getElementById('video');
        const videoError = document.getElementById('video-error');
        const canvas = document.getElementById('canvas');
        const takePictureBtn = document.getElementById('take-picture-btn'); // Ensure this button exists in your HTML
        const captureBtn = document.getElementById('capture-btn');
        const profilePictureInput = document.getElementById('profile-picture');
        const ok = document.getElementById('ok');
        const skip = document.getElementById('skip');
        const uploadButton = document.getElementById('uploadButton');
        const headingContent = document.getElementById('heading-content');
        document.getElementById('content').innerText = "We Don't Have Your Profile Picture";


        // Function to start video streaming
        function startVideo() {
            if (typeof navigator.mediaDevices !== 'undefined') { // Check if mediaDevices is defined
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(stream => {
                        video.srcObject = stream;
                        video.play(); // Ensure the video is playing
                        video.style.display = "block"; // Show video element
                        captureBtn.style.display = "inline-block"; // Show capture button
                        headingContent.style.display = "none"; // Hide heading content
                        takePictureBtn.style.display = "none"; // Hide take picture button
                    })
                    .catch(err => {
                        videoError.innerText = "Camera access was denied or not available. Please allow access or use another device.";
                    });
            } else {
                videoError.innerText = "Device not found!"; // Use innerText to set message
            }

        }

        // Show the video when the "Take Picture" button is clicked
        takePictureBtn.addEventListener('click', startVideo);

        // Capture the image from the webcam and store it as a base64 string
        captureBtn.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
            const dataURL = canvas.toDataURL('image/png');
            profilePictureInput.value = dataURL; // Store base64 image in hidden input
            // alert('Image captured!');
            video.style.display = "none"; // Hide video after capturing
            captureBtn.style.display = "none"; // Hide capture button
            ok.style.display = "inline-block";
            document.getElementById('content').innerText = "Picture Captured";
            uploadButton.style.display = "inline-block";
        });
    </script>

    <script src="{{ asset('js/CheckInJS/main.js') }}"></script>
</body>

</html>