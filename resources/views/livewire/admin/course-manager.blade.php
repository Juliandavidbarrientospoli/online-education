<div>
    <h1>Gestión de Cursos</h1>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Formulario para crear o editar cursos -->
    <form wire:submit.prevent="{{ $isEditing ? 'updateCourse' : 'createCourse' }}">
        <div>
            <label for="title">Título</label>
            <input type="text" wire:model="title" id="title">
            @error('title') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="description">Descripción</label>
            <textarea wire:model="description" id="description"></textarea>
            @error('description') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="age_group">Grupo de Edad</label>
            <select wire:model="age_group" id="age_group">
                <option value="">Seleccione</option>
                <option value="5-8">5-8</option>
                <option value="9-13">9-13</option>
                <option value="14-16">14-16</option>
                <option value="16+">16+</option>
            </select>
            @error('age_group') <span>{{ $message }}</span> @enderror
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
            <button type="submit">{{ $isEditing ? 'Actualizar' : 'Crear' }} Curso</button>
            @if($isEditing)
                <button type="button" wire:click="resetForm">Cancelar</button>
            @endif
        </div>
    </form>

    <!-- Tabla de cursos existentes -->
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Grupo de Edad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->category->name }}</td>
                    <td>{{ $course->age_group }}</td>
                    <td>
                        <button wire:click="editCourse({{ $course->id }})">Editar</button>
                        <button wire:click="deleteCourse({{ $course->id }})">Eliminar</button>
                        <a href="{{ route('admin.videos', $course->id) }}">Gestionar Videos</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
