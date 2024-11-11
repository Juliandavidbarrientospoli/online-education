<div class="container p-4 mx-auto mt-10 bg-white rounded-lg shadow-lg">
    <h1 class="mb-8 text-3xl font-bold text-gray-800">Usuarios Registrados y Progreso en Cursos</h1>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
        @foreach($users as $user)
            <div class="p-6 border border-yellow-400 rounded-lg shadow-md bg-yellow-50 hover:shadow-lg">
                <h2 class="text-2xl font-semibold text-yellow-600">{{ $user->name }}</h2>
                <p class="text-gray-700">Correo: {{ $user->email }}</p>
                <h3 class="mt-4 text-lg font-semibold">Progreso en Cursos</h3>

                @foreach($user->inscriptions as $inscription)
                    <div class="p-4 mt-4 bg-white rounded shadow-md">
                        <h4 class="font-semibold">{{ $inscription->course->title }}</h4>
                        <div wire:poll.10s="updateProgress({{ $inscription->id }})">
                            <p>Progreso: {{ $inscription->progress }}%</p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $inscription->progress }}%"></div>
                            </div>
                        </div>
                        <h5 class="mt-2 font-semibold">Videos en el curso:</h5>
                        <ul class="list-disc list-inside">
                            @foreach($inscription->course->videos as $video)
                                <li>{{ $video->title }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
