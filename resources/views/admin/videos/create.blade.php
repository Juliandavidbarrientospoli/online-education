@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto mt-10 bg-white rounded-lg shadow-lg">
    <h1 class="mb-8 text-3xl font-bold text-gray-800">Agregar Nuevo Video a un Curso</h1>

    @if (session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Selección del curso -->
        <div class="mb-4">
            <label for="course_id" class="block text-sm font-medium text-gray-700">Seleccionar Curso</label>
            <select name="course_id" id="course_id" class="block w-full p-2 mt-1 border border-gray-300 rounded">
                <option value="">Seleccione un curso</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
            @error('course_id') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Título del video -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Título del Video</label>
            <input type="text" name="title" id="title" class="block w-full p-2 mt-1 border border-gray-300 rounded" placeholder="Ingrese el título del video" value="{{ old('title') }}">
            @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- URL o archivo de video -->
        <div class="mb-4">
            <label for="video_url" class="block text-sm font-medium text-gray-700">URL del Video</label>
            <input type="url" name="video_url" id="video_url" class="block w-full p-2 mt-1 border border-gray-300 rounded" placeholder="Ingrese la URL del video" value="{{ old('video_url') }}">
            @error('video_url') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Botón de enviar -->
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Agregar Video</button>
        </div>
    </form>
</div>
@endsection
