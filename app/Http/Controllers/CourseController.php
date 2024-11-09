<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;

class CourseController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('create', compact('categories'));
    }

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
        $course->created_by = auth()->id(); // Aquí se asigna el usuario autenticado

        // Guardar imagen si está presente
        if ($request->hasFile('image')) {
            $course->image_url = $request->file('image')->store('courses', 'public');
        }

        $course->save();

        return redirect()->route('courses.index')->with('success', 'Curso creado con éxito.');


        if ($request->hasFile('image')) {
            $course->image_url = $request->file('image')->store('courses', 'public');
        }

        $course->save();

        return redirect()->route('courses.create')->with('success', 'Curso creado con éxito.');
    }
}
