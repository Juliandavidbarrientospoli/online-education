<div>
    <h1>Gestión de Videos para el Curso: {{ $course->title }}</h1>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Formulario para crear o editar videos -->
    <form wire:submit.prevent="{{ $isEditing ? 'updateVideo' : 'createVideo' }}">
        <div>
            <label for="title">Título</label>
            <input type="text" wire:model="title" id="title">
            @error('title') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="url">URL (YouTube)</label>
            <input type="text" wire:model="url" id="url">
            @error('url') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="category_id">Categoría</label>
            <select wire:model="category_id" id="category_id">
                <option value="">Seleccione</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <button type="submit">{{ $isEditing ? 'Actualizar' : 'Agregar' }} Video</button>
            @if($isEditing)
                <button type="button" wire:click="resetForm">Cancelar</button>
            @endif
        </div>
    </form>

    <!-- Tabla de videos existentes -->
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($videos as $video)
                <tr>
                    <td>{{ $video->title }}</td>
                    <td>{{ $video->category->name }}</td>
                    <td>
                        <button wire:click="editVideo({{ $video->id }})">Editar</button>
                        <button wire:click="deleteVideo({{ $video->id }})">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
