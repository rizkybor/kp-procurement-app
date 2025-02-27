<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles        

        <script>
            if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
                document.querySelector('html').classList.remove('dark');
                document.querySelector('html').style.colorScheme = 'light';
            } else {
                document.querySelector('html').classList.add('dark');
                document.querySelector('html').style.colorScheme = 'dark';
            }
        </script>
    </head>
    <body class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400">

        <main class="flex flex-col md:flex-row items-center justify-center min-h-screen px-6 bg-gray-900 ">
            
            <!-- Left Side -->
            <div class="w-full md:w-1/2 flex flex-col justify-center p-8 text-left h-full md:h-screen text-white">
                <h2 class="text-2xl font-bold">Procurement App</h2>
                <ul class="mt-4 space-y-4">
                    <li class="flex items-center space-x-2">
                        <span class="text-blue-500">✔</span>
                        <span>Get started quickly with developer-friendly APIs.</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-blue-500">✔</span>
                        <span>Support any business model with private hosting.</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-blue-500">✔</span>
                        <span>Join millions of businesses using Flowbite.</span>
                    </li>
                </ul>
            </div>
            
            <!-- Right Side (Login Card) -->
            <div class="w-full md:w-1/2 flex items-center justify-center p-8 h-full md:h-screen">
                <div class="w-full max-w-lg bg-gray-100 rounded-xl shadow-lg p-8">
                    <div class="w-full max-w-sm mx-auto">
                        {{ $slot }}
                    </div>
                </div>
            </div>
            
        </main>

        @livewireScriptConfig
    </body>
</html>