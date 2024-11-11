<div class="container p-6 mx-auto mt-10 bg-white rounded-lg shadow-md" wire:poll.keep-alive>
    <h1 class="text-4xl font-bold text-center text-gray-800">{{ $this->course->title }}</h1>
    <p class="mt-2 text-lg text-center text-gray-600">{{ $this->course->description }}</p>

    @foreach ($this->course->videos as $video)
        <div class="relative p-6 mt-6 bg-gray-100 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-800">{{ $video->title }}</h2>
            <div class="flex justify-center mt-4">
                @php
                    $youtubeId = $this->getYouTubeIdFromUrl($video->url);
                @endphp
                @if ($youtubeId)
                    <iframe width="100%" height="auto" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allowfullscreen class="w-full rounded-lg shadow-md lg:w-3/4 h-96"></iframe>
                @else
                    <video src="{{ asset('storage/' . $video->url) }}" controls class="w-full rounded-lg shadow-md lg:w-3/4 h-96"></video>
                @endif
            </div>

            <div class="flex items-center justify-between mt-6">
                <div wire:key="complete-{{ $video->id }}">
                    @if(in_array($video->id, $this->completedVideos))
                        <span class="px-4 py-2 text-green-600 bg-green-100 rounded-lg">Completado</span>
                    @else
                        <button wire:click="markVideoAsCompleted({{ $video->id }})" class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700" wire:loading.attr="disabled">
                            <span>Marcar como Completado</span>
                        </button>
                    @endif
                </div>
                <div class="absolute flex items-center space-x-2 bottom-4 right-4" wire:key="like-{{ $video->id }}">
                    <button wire:click="toggleLike({{ $video->id }})" class="focus:outline-none" wire:loading.attr="disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $video->likes->contains('user_id', auth()->id()) ? 'red' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8 text-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                    <span class="text-gray-700">{{ $video->likes->count() }} Likes</span>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700">Comentarios</h3>
                <div class="mt-4 space-y-3">
                    @foreach ($video->comments as $comment)
                        <div class="p-3 bg-white rounded-lg shadow-sm">
                            <p class="text-gray-800"><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                        </div>
                    @endforeach
                </div>

                <form wire:submit.prevent="addComment({{ $video->id }})" class="flex items-start mt-4">
                    <textarea wire:model.defer="newComment" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm" placeholder="Añadir un comentario..."></textarea>
                    <button type="submit" class="px-4 py-2 ml-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Comentar</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
