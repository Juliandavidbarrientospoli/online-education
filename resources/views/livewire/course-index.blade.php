<div class="container px-4 mx-auto my-8">
    <div class="mb-6">
        <div class="flex flex-wrap items-center gap-4">
            <!-- Filtro de categoría -->
            <div class="w-full md:w-auto">
                <label for="category" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select id="category" wire:model.live="selectedCategory" class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm form-select focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Todas las Categorías</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro de grupo de edad -->
            <div class="w-full md:w-auto">
                <label for="age-group" class="block text-sm font-medium text-gray-700">Grupo de Edad</label>
                <select id="age-group" wire:model.live="selectedAgeGroup" class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm form-select focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Todos los Grupos de Edad</option>
                    @foreach ($ageGroups as $age)
                        <option value="{{ $age }}">{{ $age }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Búsqueda por título/descripción -->
            <div class="w-full md:flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                <div class="flex mt-1">
                    <input id="search" type="text" wire:model.live="searchTerm" class="flex-1 border border-gray-300 rounded-lg shadow-sm form-input focus:ring-indigo-500 focus:border-indigo-500" placeholder="Buscar por título o descripción">
                </div>
            </div>

            <!-- Botón Crear Curso -->
            <div class="mt-4 md:mt-0 md:ml-auto">
                <a href="{{ route('courses.create') }}" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">
                    Crear Curso
                </a>
            </div>
        </div>
    </div>

    <!-- Cuadrícula para mostrar cursos -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
        @forelse ($courses as $course)
            <div class="overflow-hidden transition-all duration-300 transform bg-white rounded-lg shadow-lg hover:shadow-2xl hover:scale-105">
                <img src="{{ asset('storage/' . $course->image_url ?? '/api/placeholder/400/300') }}" alt="Imagen del curso" class="object-cover w-full h-32">
                <div class="p-4">
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">{{ $course->title }}</h3>
                    <p class="mb-4 text-sm text-gray-700 truncate">{{ $course->description }}</p>
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-block px-6 py-2 text-sm font-medium text-white transition duration-300 bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Ver Curso
                    </a>
                </div>
            </div>
        @empty
            <div class="col">
                <p class="text-gray-600">No se encontraron cursos.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $courses->links() }}
    </div>
</div>
