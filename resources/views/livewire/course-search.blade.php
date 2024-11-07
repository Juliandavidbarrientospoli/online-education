<div>
    <h1>Búsqueda de Cursos</h1>

    <!-- Formulario de búsqueda -->
    <div>
        <input type="text" wire:model.debounce.500ms="searchTerm" placeholder="Buscar por nombre">
        <select wire:model="category_id">
            <option value="">Todas las categorías</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <select wire:model="age_group">
            <option value="">Todos los grupos de edad</option>
            @foreach($age_groups as $group)
                <option value="{{ $group }}">{{ $group }}</option>
            @endforeach
        </select>
    </div>

    <!-- Lista de cursos -->
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
            @forelse($courses as $course)
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->category->name }}</td>
                    <td>{{ $course->age_group }}</td>
                    <td>
                        <a href="{{ route('courses.detail', $course->id) }}">Ver Detalles</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No se encontraron cursos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
