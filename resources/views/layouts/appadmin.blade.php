<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/prms-logo 2.jpg') }}">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!--loading spinner-->
    <x-loading-spinner />

    <div id="app">
        <div class="tw-page">
            <div class="tw-page-wrapper">
                @include('layouts.navigation') <!-- Includes: views/layouts/navigation.blade.php -->
                <div class="tw-page-body">
                    @yield('contentadmin') <!-- every page's section "content" goes here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/dialog.js"></script>

    <!-- Add this script to hide the alert after 5 seconds -->
    <script>
        // to show loading spinner
        $(window).on("load", function() {
            $(".loader-wrapper").fadeOut();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('session-alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    // Optionally, remove the element from the DOM after the fade-out
                    setTimeout(() => { alert.remove(); }, 500); // 500ms matches the CSS transition duration
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    </script>
</body>
</html>
