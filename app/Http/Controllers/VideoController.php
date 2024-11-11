<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Course;
use App\Models\Category;
class VideoController extends Controller
{
    /**
     * Muestra el formulario para crear un nuevo video.
     *
     * @return \Illuminate\View\View La vista para crear un video, con la lista de cursos y categorías.
     */
    public function create()
    {
        $courses = Course::all();
        $categories = Category::all();
        return view('admin.videos.create', compact('courses', 'categories'));
    }

    /**
     * Almacena un nuevo video en la base de datos.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP que contiene los datos del video.
     * @return \Illuminate\Http\RedirectResponse Redirige al formulario de creación con un mensaje de éxito.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'url' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $video = Video::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'url' => $request->url,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('videos.create')->with('success', 'Video creado exitosamente.');
    }
}
