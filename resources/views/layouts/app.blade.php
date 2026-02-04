<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Torre de Batalla') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('front_end/images/favicon.png') }}">
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <div class="min-h-screen flex flex-col" style="background: linear-gradient(120deg, #e0f7fa 0%, #fff 100%); min-height: 100vh;">
            <!-- Navbar -->
            <div class="sticky top-0 z-50 shadow-lg bg-white/80 backdrop-blur border-b border-gray-200">
                @include('layouts.navigation')
            </div>

            <!-- Main Content -->
            <main class="flex-1 flex flex-col items-center justify-center py-10 px-2 sm:px-6 lg:px-8">
                <div class="w-full max-w-5xl bg-white/90 rounded-2xl shadow-xl p-6 sm:p-10 mt-6 mb-8">
                    {{ $slot }}
                </div>
            </main>
    </div>
</body>
</html>
