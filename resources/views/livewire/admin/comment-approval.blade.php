<div>
    <h1>Aprobación de Comentarios</h1>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Tabla de comentarios pendientes de aprobación -->
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Video</th>
                <th>Comentario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $comment)
                <tr>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ $comment->video->title }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>
                        <button wire:click="approveComment({{ $comment->id }})">Aprobar</button>
                        <button wire:click="deleteComment({{ $comment->id }})">Eliminar</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay comentarios pendientes de aprobación.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
