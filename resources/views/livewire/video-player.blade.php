<div>
    <h1>{{ $video->title }}</h1>

    <!-- Incrustar video de YouTube -->
    <iframe width="560" height="315" src="{{ $video->url }}" frameborder="0" allowfullscreen></iframe>

    <!-- Botón de like -->
    <div>
        @if($isLiked)
            <button wire:click="unlike">Quitar Like</button>
        @else
            <button wire:click="like">Dar Like</button>
        @endif
    </div>

    <!-- Formulario para agregar comentarios -->
    <div>
        <h2>Agregar Comentario</h2>
        @if (session()->has('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif
        <textarea wire:model="content" placeholder="Escribe tu comentario"></textarea>
        @error('content') <span>{{ $message }}</span> @enderror
        <button wire:click="addComment">Enviar</button>
    </div>

    <!-- Lista de comentarios -->
    <div>
        <h2>Comentarios</h2>
        @forelse($comments as $comment)
            <div>
                <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
            </div>
        @empty
            <p>No hay comentarios para este video.</p>
        @endforelse
    </div>
</div>
