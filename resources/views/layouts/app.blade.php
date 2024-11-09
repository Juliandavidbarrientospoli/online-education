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

        <!-- Tailwind CSS from CDN -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen text-black bg-gradient-to-r from-gray-800 to-gray-600">
            <!-- Menú de navegación -->
            <nav class="sticky top-0 z-50 p-5 bg-gray-900 shadow-md">
                <div class="container flex items-center justify-between mx-auto">
                    <!-- Logo o Nombre -->
                    <a href="/dashboard" class="text-2xl font-semibold text-white transition duration-300 ease-in-out hover:text-gray-300">Mi Proyecto</a>

                    <!-- Menú de navegación -->
                    <ul class="flex space-x-6 text-lg">
                        <li><a href="{{ route('profile') }}" class="text-white transition duration-300 hover:text-gray-300">Perfil</a></li>

                        <!-- Menú para el Administrador -->
                        @role('admin') <!-- Verifica si el usuario tiene el rol de admin -->
                            <li><a href="{{ route('admin.panel') }}" class="text-white transition duration-300 hover:text-gray-300">Menú Administrador</a></li>
                        @endrole

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-white transition duration-300 hover:text-gray-300">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="py-4 bg-white shadow-lg">
                    <div class="container mx-auto text-center">
                        <h2 class="text-3xl font-bold text-gray-800">{{ $header }}</h2>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="w-full h-auto p-8 mx-auto mt-6 bg-white border border-gray-300 rounded-lg shadow-lg">
                @yield('content') <!-- Para vistas tradicionales -->
                {{ $slot ?? '' }} <!-- Para componentes Livewire -->
            </main>
        </div>
    </body>
</html>
