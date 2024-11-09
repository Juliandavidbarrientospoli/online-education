<div class="container p-4 mx-auto mt-10 bg-white rounded-lg shadow-md">
    <!-- Título y Descripción del Curso -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800">{{ $this->course->title }}</h1>
        <p class="mt-2 text-lg text-gray-600">{{ $this->course->description }}</p>
    </div>

    <!-- Detalles del Curso -->
    <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-3">
        <!-- Información del Curso -->
        <div class="col-span-2">
            <div class="p-6 rounded-lg shadow-lg bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-700">Detalles del Curso</h2>
                <table class="w-full mt-4 border border-gray-200 rounded-lg">
                    <tbody>
                        <tr class="border-b border-gray-200">
                            <th class="p-4 font-medium text-left text-gray-700 bg-gray-100">Categoría</th>
                            <td class="p-4 text-gray-700">{{ $this->course->category->name }}</td>
                        </tr>
                        <tr>
                            <th class="p-4 font-medium text-left text-gray-700 bg-gray-100">Grupo de Edad</th>
                            <td class="p-4 text-gray-700">{{ $this->course->age_group }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Imagen y Información Extra -->
        <div class="flex flex-col items-center">
            <div class="w-full mb-6 overflow-hidden rounded-lg shadow-lg">
                <img src="{{ asset('storage/' . $course->image_url ?? '/api/placeholder/400/300') }}" alt="Imagen del curso" class="object-cover w-full h-40">
            </div>

            @if(session('message'))
                <div class="p-4 mt-4 text-white bg-green-500 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            <h3 class="text-lg font-semibold text-gray-700">Sobre este Curso</h3>
            <p class="mt-2 text-center text-gray-600">Este curso te ayudará a aprender sobre {{ strtolower($this->course->category->name) }} de manera efectiva y aplicable.</p>

            <!-- Botón de Inscripción o Ver Detalles -->
            @if(!$userIsEnrolled)
                <form action="{{ route('courses.inscription', $course->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 mt-6 text-white transition duration-200 bg-blue-600 rounded-lg shadow hover:bg-blue-700">
                        Inscribirse en el Curso
                    </button>
                </form>
            @else
                <a href="{{ route('courses.details', $this->course->id) }}" class="px-4 py-2 mt-6 text-white transition duration-200 bg-green-600 rounded-lg shadow hover:bg-green-700">
                    Ver Detalles
                </a>
            @endif
        </div>
    </div>
</div>
