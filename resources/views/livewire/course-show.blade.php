<div class="container px-6 py-8 mx-auto shadow-2xl bg-gradient-to-br from-indigo-100 via-white to-indigo-50 rounded-xl">
    <!-- Título y Descripción del Curso -->
    <div class="mb-10 text-center">
        <h1 class="text-5xl font-extrabold text-indigo-800">{{ $this->course->title }}</h1>
        <p class="mt-4 text-xl text-gray-700">{{ $this->course->description }}</p>
    </div>

    <!-- Detalles del Curso -->
    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <!-- Información del Curso -->
        <div class="col-span-2">
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold text-indigo-700">Detalles del Curso</h2>
                <table class="w-full mt-4 border-t border-gray-200">
                    <tbody>
                        <tr class="border-b border-gray-100">
                            <th class="px-4 py-4 font-semibold text-left text-gray-600 bg-gray-50">Categoría</th>
                            <td class="px-4 py-4 text-gray-700">{{ $this->course->category->name }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-4 font-semibold text-left text-gray-600 bg-gray-50">Grupo de Edad</th>
                            <td class="px-4 py-4 text-gray-700">{{ $this->course->age_group }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Imagen y Información Extra -->
        <div class="flex flex-col items-center">
            <div class="w-full mb-6 overflow-hidden rounded-lg shadow-lg">
                <img src="{{ asset('storage/' . $course->image_url ?? '/api/placeholder/400/400') }}" alt="Imagen del curso" class="object-cover w-full h-56 rounded-lg">
            </div>

            @if(session('message'))
                <div class="px-6 py-4 mt-4 text-white bg-green-500 rounded-lg shadow-md">
                    {{ session('message') }}
                </div>
            @endif

            <h3 class="text-2xl font-semibold text-indigo-700">Sobre este Curso</h3>
            <p class="max-w-md mt-4 text-center text-gray-600">Este curso te ayudará a aprender sobre {{ strtolower($this->course->category->name) }} de manera efectiva y aplicable.</p>

            <!-- Botón según el rol -->
            <div class="mt-6">
                @role('admin')
                    <a href="{{ route('courses.details', $this->course->id) }}" class="inline-block px-6 py-3 text-lg font-semibold text-white transition duration-300 bg-indigo-600 rounded-lg shadow-lg hover:bg-indigo-700">
                        Ver Detalles (Admin)
                    </a>
                @else
                    @if(!$userIsEnrolled)
                        <form action="{{ route('courses.inscription', $course->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-block px-6 py-3 text-lg font-semibold text-white transition duration-300 bg-indigo-600 rounded-lg shadow-lg hover:bg-indigo-700">
                                Inscribirse en el Curso
                            </button>
                        </form>
                    @else
                        <a href="{{ route('courses.details', $this->course->id) }}" class="inline-block px-6 py-3 text-lg font-semibold text-white transition duration-300 bg-green-600 rounded-lg shadow-lg hover:bg-green-700">
                            Ver Detalles
                        </a>
                    @endif
                @endrole
            </div>
        </div>
    </div>
</div>
