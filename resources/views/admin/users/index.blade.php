@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-2xl font-bold">Lista de Usuarios y Cursos</h1>
        <div class="table-responsive">
            <table class="table mt-4 table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Cursos Inscritos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($user->courses as $course)
                                    <span class="badge bg-primary">{{ $course->title }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
