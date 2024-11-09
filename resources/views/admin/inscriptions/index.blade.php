@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-2xl font-bold">Lista de Inscripciones</h1>
        <div class="table-responsive">
            <table class="table mt-4 table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Usuario</th>
                        <th>Curso</th>
                        <th>Progreso</th>
                        <th>Video Actual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inscriptions as $inscription)
                        <tr>
                            <td>{{ $inscription->user->name }}</td>
                            <td>{{ $inscription->course->title }}</td>
                            <td>{{ $inscription->progress }}%</td>
                            <td>{{ $inscription->current_video_id ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
