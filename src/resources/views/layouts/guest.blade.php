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
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-[100vh] font-sans text-gray-900 antialiased">
        <header class="h-[10%]">
            <div class="h-[100%] content-center mx-auto">
                <div class="h-[100%] flex justify-between">
                    <div class="content-center h-full">
                        <h1 class="text-2xl p-5">Atte</h1>
                    </div>
                </div>
            </div>
        </header>
        <div class="flex flex-col h-[80%] sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        <footer class="h-[10%] text-center content-center">Atte,inc.</footer>
    </body>
</html>
