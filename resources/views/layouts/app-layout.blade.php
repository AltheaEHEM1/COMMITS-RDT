<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', env('APP_NAME'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('src/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('src/css/documents.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/prms-logo 2.jpg') }}">

    <!-- Custom styles for error modals -->
    @stack('styles')
    <style>
        /* Transitions and animations */
        .transform {
            transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        }

        /* Error modal with improved animations */
        #date-error-modal-container {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Scale effects */
        .scale-100 {
            transform: scale(1);
        }

        .scale-95 {
            transform: scale(0.95);
        }

        .scale-102 {
            transform: scale(1.02);
        }

        /* Fix message animation */
        #error-fix-message {
            transition: opacity 0.5s ease;
        }

        /* Countdown animation */
        #error-modal-countdown {
            display: inline-block;
            min-width: 1em;
            text-align: center;
            transition: all 0.2s ease;
        }

        /* Modern rounded corners */
        #date-error-modal-container {
            border-radius: 12px;
        }

        /* Clean button style */
        #date-error-modal button {
            transition: all 0.2s ease;
        }

        body {
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 scrollbar-hidden">

    <header
        class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-30 w-full h-14 border-b border-gray-200 text-sm py-2.5 lg:ps-65">
        <x-navbar />
    </header>

    <div class="h-full antialiased">
        <!-- SIDEBAR -->
        <x-sidebar />

        <!-- Notification Messages -->
        {{-- @if (session('success'))
            <div id="session-alert" class="fixed z-50 text-white tw-p-4 tw-mb-4 tw-text-green-800 tw-bg-green-200 tw-rounded-lg"
                style="transition: opacity 0.5s;">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div id="session-alert" class="fixed z-50 tw-p-4 tw-mb-4 tw-text-red-800 tw-bg-red-200 tw-rounded-lg"
                style="transition: opacity 0.5s;">
                {{ session('error') }}
            </div>
        @endif --}}

        <main class="h-full md:ml-64">
            <!--loading spinner-->
            <x-loading-spinner />

            <div class="h-full p-4">
                <!--Main Content-->
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/dialog.js"></script>

    <!-- Add this script to hide the alert after 5 seconds -->
    <script>
        // to show loading spinner
        $(window).on("load", function() {
            $(".loader-wrapper").fadeOut('fast');
        });

        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('session-alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    // Optionally, remove the element from the DOM after the fade-out
                    setTimeout(() => {
                        alert.remove();
                    }, 500); // 500ms matches the CSS transition duration
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/date-validation.js') }}"></script>
    @yield('scripts')
    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
