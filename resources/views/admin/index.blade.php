@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto mt-10 bg-white rounded-lg shadow-lg">
    <h1 class="mb-8 text-3xl font-bold text-gray-800">Panel de Administración</h1>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
        <!-- Cuadro para crear un curso -->
        <div class="p-6 border border-blue-200 rounded-lg shadow-md bg-blue-50 hover:shadow-lg">
            <h2 class="mb-4 text-2xl font-semibold text-blue-800">Gestionar Cursos</h2>
            <p class="mb-6 text-gray-700">Administra todos los cursos, agrega o edita información y asigna categorías.</p>
            <div class="flex justify-between">
                <a href="{{ route('courses.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Crear Curso</a>
                <a href="{{ route('courses.index') }}" class="px-4 py-2 text-blue-600 bg-white border border-blue-600 rounded hover:bg-blue-50">Ver Cursos</a>
            </div>
        </div>

        <!-- Cuadro para agregar video a un curso -->
        <div class="p-6 border border-green-200 rounded-lg shadow-md bg-green-50 hover:shadow-lg">
            <h2 class="mb-4 text-2xl font-semibold text-green-800">Gestionar Videos</h2>
            <p class="mb-6 text-gray-700">Agrega nuevos videos a cursos y clasifícalos en categorías adecuadas.</p>
            <div class="flex justify-between">
                <a href="{{ route('videos.create') }}" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Agregar Video</a>
            </div>
        @if (session('success'))
             <div class="alert alert-success">
            {{session('success') }}
             </div>
         @endif
        </div>

        <div class="p-6 border border-yellow-400 rounded-lg shadow-md bg-yellow-50 hover:shadow-lg">
            <h2 class="mb-4 text-2xl font-semibold text-yellow-600">Gestionar Usuarios</h2>
            <p class="mb-6 text-gray-700">Ver los usuarios registrados en los cursos, ver progresos
                y más</p>
            <div class="flex justify-between">
                <a href="{{ route('admin.users.progress') }}" class="px-4 py-2 text-white bg-yellow-600 rounded hover:bg-yellow-700">Ver Usuarios</a>
            </div>
    </div>
</div>
@endsection
