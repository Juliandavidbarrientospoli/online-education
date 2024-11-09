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
    <body class="font-sans antialiased bg-light">
        <div class="flex items-center justify-center min-h-screen" style="background: linear-gradient(135deg, #072d4d, #f7f6f5); color: #fff;">
            <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
                <h2 class="mb-6 text-2xl font-semibold text-center text-gray-700">Iniciar Sesión</h2>

                <!-- Formulario de Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Correo Electrónico</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-2 mt-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @error('email')
                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-700">Contraseña</label>
                        <input type="password" id="password" name="password" required class="w-full px-4 py-2 mt-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @error('password')
                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="text-blue-600">
                            <label for="remember" class="ml-2 text-sm text-gray-700">Recuérdame</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">¿Olvidaste tu contraseña?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">Iniciar Sesión</button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">¿No tienes una cuenta? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">Regístrate aquí</a></p>
                </div>
            </div>
        </div>
    </body>
</html>
