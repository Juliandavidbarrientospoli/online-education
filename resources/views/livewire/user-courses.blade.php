<div>
    <h1>Mis Cursos</h1>

    <!-- Lista de cursos inscritos -->
    <table>
        <thead>
            <tr>
                <th>Curso</th>
                <th>Progreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscriptions as $inscription)
                <tr>
                    <td>{{ $inscription->course->title }}</td>
                    <td>{{ $inscription->progress }}%</td>
                    <td>
                        <a href="{{ route('courses.detail', $inscription->course->id) }}">Continuar Curso</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No estás inscrito en ningún curso.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
