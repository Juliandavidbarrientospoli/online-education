@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-lg p-8 bg-white rounded-lg shadow-lg">
        <h2 class="mb-8 text-2xl font-bold text-center text-blue-600">Crear Nuevo Curso</h2>

        @if (session('success'))
        <div class="p-4 mb-6 text-center text-green-800 bg-green-200 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="title" class="block mb-2 font-medium text-gray-700">Título del Curso</label>
                <input type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingrese el título del curso" value="{{ old('title') }}">
                @error('title') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block mb-2 font-medium text-gray-700">Descripción</label>
                <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Descripción del curso">{{ old('description') }}</textarea>
                @error('description') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="age_group" class="block mb-2 font-medium text-gray-700">Grupo de Edad</label>
                <select id="age_group" name="age_group" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccione un grupo de edad</option>
                    <option value="5-8" {{ old('age_group') == '5-8' ? 'selected' : '' }}>5-8 años</option>
                    <option value="9-13" {{ old('age_group') == '9-13' ? 'selected' : '' }}>9-13 años</option>
                    <option value="14-16" {{ old('age_group') == '14-16' ? 'selected' : '' }}>14-16 años</option>
                    <option value="16+" {{ old('age_group') == '16+' ? 'selected' : '' }}>16+ años</option>
                </select>
                @error('age_group') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="category_id" class="block mb-2 font-medium text-gray-700">Categoría</label>
                <select id="category_id" name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccione una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="image" class="block mb-2 font-medium text-gray-700">Imagen del Curso</label>
                <input type="file" id="image" name="image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('image') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-center">
                <button type="submit" class="px-6 py-2 text-lg font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Crear Curso</button>
            </div>
        </form>
    </div>
</div>
@endsection
