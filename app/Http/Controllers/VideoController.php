<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Course;

class VideoController extends Controller
{
    public function create()
    {
        $courses = Course::all();
        return view('admin.videos.create', compact('courses'));
    }

    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'url' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Creación del video en la base de datos
        $video = Video::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'url' => $request->url,
            'category_id' => $request->category_id,
        ]);

        // Confirmación de éxito
        return redirect()->route('videos.create')->with('success', 'Video creado exitosamente.');
    }
}
