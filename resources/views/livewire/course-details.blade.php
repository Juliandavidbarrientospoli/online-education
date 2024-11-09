<div class="container p-4 mx-auto mt-10 bg-white rounded-lg shadow-md">
    <!-- Información del curso -->
    <h1 class="text-4xl font-bold text-center text-gray-800">{{ $this->course->title }}</h1>
    <p class="mt-2 text-lg text-center text-gray-600">{{ $this->course->description }}</p>

    <!-- Lista de videos del curso -->
    @foreach ($this->course->videos as $video)
        <div class="p-4 mt-6 bg-gray-100 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-800">{{ $video->title }}</h2>

            <!-- Verifica si la URL es de YouTube y muestra el video correctamente -->
            @php
                $youtubeId = $this->getYouTubeIdFromUrl($video->url); // Llamada al método para obtener el ID de YouTube
            @endphp

            @if ($youtubeId)
                <!-- Video de YouTube embebido con iframe (ajustado para ser más grande) -->
                <div class="flex justify-center mt-4">
                    <iframe width="100%" height="auto" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full rounded-lg shadow-md lg:w-3/4 h-96"></iframe>
                </div>
            @else
                <!-- Video local o de otro tipo (ajustado para ser más grande) -->
                <div class="flex justify-center mt-4">
                    <video src="{{ asset('storage/' . $video->url) }}" controls class="w-full rounded-lg shadow-md lg:w-3/4 h-96"></video>
                </div>
            @endif

            <!-- Sección de comentarios -->
            <div class="mt-4">
                <h3 class="text-lg font-semibold text-gray-700">Comentarios</h3>
                <div class="space-y-3">
                    @foreach ($video->comments as $comment)
                        <div class="p-3 bg-white rounded-lg shadow-sm">
                            <p class="text-gray-800"><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Formulario para agregar un nuevo comentario -->
                <form wire:submit.prevent="addComment({{ $video->id }})" class="mt-4">
                    <textarea wire:model="newComment" class="w-full p-2 border rounded-lg shadow-sm" placeholder="Añadir un comentario..."></textarea>
                    <button type="submit" class="px-4 py-2 mt-2 text-white transition duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">Comentar</button>
                </form>
            </div>

            <!-- Botón de like -->
            <div class="mt-4">
                <button wire:click="toggleLike({{ $video->id }})" class="px-4 py-2 text-white transition duration-300 bg-red-500 rounded-lg hover:bg-red-600">
                    {{ $video->likes->contains('user_id', auth()->id()) ? 'Quitar Like' : 'Dar Like' }}
                </button>
                <span class="ml-2 text-gray-700">{{ $video->likes->count() }} Likes</span>
            </div>
        </div>
    @endforeach
</div>
