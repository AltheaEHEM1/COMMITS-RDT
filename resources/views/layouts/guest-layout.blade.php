<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ env('APP_NAME') }} </title>
    @vite('resources/css/app.css')
    <script src="{{ asset('src/js/iziToast.min.js') }}"></script> {{-- toast notification js --}}
    <script defer src="{{ asset('src/js/login.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel ="stylesheet" href="{{ asset('src/css/iziToast.min.css') }}" /> {{-- toast notification css --}}
    <link rel="stylesheet" href="{{asset('src/css/login.css')}}">
    <link rel="icon" type="image/png" href="{{ asset('images/prms-logo 2.jpg') }}">
</head>

<body class="h-screen w-screen flex items-center justify-center bg-blue-50 py-12 px-4 sm:px-6 lg:px-8 overflow-hidden relative">

    <!-- Background shapes -->
    <div class="shape-blob1"></div>
    <div class="shape-blob2"></div>
    <div class="shape-circle1"></div>
    <div class="shape-circle2"></div>

    <div class="max-w-lg w-full space-y-8 content-wrapper bg-white bg-opacity-90 p-10 rounded-xl shadow-xl">
        @yield('guest_content')
    </div>

    {{-- <section class="bg-gray-50 flex items-center w-screen h-screen justify-center md:flex-row">

        <!-- Left Side: Illustration -->
        <div class="hidden md:flex flex-col justify-center items-center w-4/5 h-full bg-cover bg-center">
            <img src="{{asset('images/prms-login-image.png')}}" alt="">
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-2/5 h-full bg-white flex items-center justify-center">
            @yield('guest_content')
        </div>

    </section> --}}
</body>
</html>
