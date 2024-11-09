<div class="container p-4 mx-auto mt-10 bg-white rounded-lg shadow-md">
    <!-- Información del curso -->
    <h1 class="text-4xl font-bold text-center text-gray-800">{{ $this->course->title }}</h1>
    <p class="mt-2 text-lg text-center text-gray-600">{{ $this->course->description }}</p>

    <!-- Lista de videos del curso -->
    @foreach ($this->course->videos as $video)
        <div class="p-4 mt-6 bg-gray-100 rounded-lg shadow">
            <h2 class="text-2xl font-semibold text-gray-800">{{ $video->title }}</h2>
            <video src="{{ asset('storage/' . $video->url) }}" controls class="w-full mt-4 rounded-lg"></video>

            <!-- Sección de comentarios -->
            <div class="mt-4">
                <h3 class="text-lg font-semibold text-gray-700">Comentarios</h3>

                <!-- Lista de comentarios -->
                <div class="space-y-3">
                    @foreach ($video->comments as $comment)
                        <div class="p-3 bg-white rounded shadow">
                            <p class="text-gray-800"><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Formulario para agregar un nuevo comentario -->
                <form wire:submit.prevent="addComment({{ $video->id }})" class="mt-4">
                    <textarea wire:model="newComment" class="w-full p-2 border rounded" placeholder="Añadir un comentario..."></textarea>
                    <button type="submit" class="px-4 py-2 mt-2 text-white bg-blue-600 rounded">Comentar</button>
                </form>
            </div>

            <!-- Botón de like -->
            <div class="mt-4">
                <button wire:click="toggleLike({{ $video->id }})" class="px-4 py-2 text-white bg-red-500 rounded">
                    {{ $video->likes->contains('user_id', auth()->id()) ? 'Quitar Like' : 'Dar Like' }}
                </button>
                <span class="ml-2 text-gray-700">{{ $video->likes->count() }} Likes</span>
            </div>
        </div>
    @endforeach
</div>
