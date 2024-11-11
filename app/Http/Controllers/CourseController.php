<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;

class CourseController extends Controller
{
    /**
     * Muestra el formulario para crear un nuevo curso.
     *
     * @return \Illuminate\View\View La vista de creación de curso con las categorías disponibles.
     */
    public function create()
    {
        $categories = Category::all();
        return view('create', compact('categories'));
    }

    /**
     * Almacena un nuevo curso en la base de datos.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP con los datos del curso.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de cursos con un mensaje de éxito.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'age_group' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->age_group = $request->age_group;
        $course->category_id = $request->category_id;
        // Asignamos el usuario autenticado como creador
        $course->created_by = auth()->id();

        // Guarda la imagen si está presente en la solicitud
        if ($request->hasFile('image')) {
            $course->image_url = $request->file('image')->store('courses', 'public');
        }

        $course->save();
        return redirect()->route('courses.index')->with('success', 'Curso creado con éxito.');
    }
}
