<div class="container px-6 mx-auto mt-10" wire:poll.keep-alive>
    <h1 class="mb-8 text-4xl font-extrabold text-center text-indigo-700">Progreso en tus Cursos</h1>

    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($inscriptions as $inscription)
            <div class="relative p-6 overflow-hidden transition duration-300 transform bg-white rounded-lg shadow-lg group hover:shadow-2xl">
                <!-- Fondo degradado de progreso -->
                <div class="absolute inset-0 z-0 transition-transform duration-500 transform scale-105 opacity-25 bg-gradient-to-tr from-blue-600 to-purple-700 group-hover:opacity-40"></div>

                <!-- Porcentaje de progreso en un borde circular -->
                <div class="absolute top-4 right-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-white rounded-full shadow-lg bg-opacity-80 ring-4 ring-blue-300 ring-offset-2 ring-offset-white">
                        <span class="text-lg font-bold text-blue-700">{{ $inscription->progress }}%</span>
                    </div>
                </div>

                <!-- Contenido del curso -->
                <div class="relative z-10">
                    <h2 class="mb-2 text-2xl font-bold text-gray-800">{{ $inscription->course->title }}</h2>
                    <p class="text-sm text-gray-600">{{ Str::limit($inscription->course->description, 100) }}</p>
                </div>

                <!-- Barra de progreso personalizada -->
                <div class="relative w-full h-2 mt-6 bg-gray-200 rounded-full">
                    <div class="absolute top-0 left-0 h-2 duration-500 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 transition-width" style="width: {{ $inscription->progress }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>
