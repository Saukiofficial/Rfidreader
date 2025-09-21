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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Reset default styles to ensure full screen layout */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            html, body {
                height: 100%;
                width: 100%;
                overflow-x: hidden;
            }

            body {
                font-family: 'Inter', 'Figtree', sans-serif;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            /* Ensure the guest layout takes full screen */
            .guest-layout-wrapper {
                min-height: 100vh;
                width: 100%;
                position: relative;
                overflow: hidden;
            }

            /* Remove any default Laravel styling that might interfere */
            .guest-content {
                width: 100%;
                height: 100%;
                position: relative;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .guest-layout-wrapper {
                    padding: 0;
                }
            }
        </style>
    </head>
    <body>
        <div class="guest-layout-wrapper">
            <div class="guest-content">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
