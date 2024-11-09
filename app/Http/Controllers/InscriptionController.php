<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    public function store(Request $request, $courseId)
    {
        // Verifica si el usuario ya está inscrito en el curso
        $existingInscription = Inscription::where('course_id', $courseId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingInscription) {
            return redirect()->route('courses.show', $courseId)
                ->with('message', 'Ya estás inscrito en este curso.');
        }

        // Crear una nueva inscripción
        Inscription::create([
            'course_id' => $courseId,
            'user_id' => Auth::id(),
            'progress' => 0,
            'current_video_id' => null
        ]);

        // Redirigir a una página de confirmación de inscripción
        return redirect()->route('courses.details', ['courseId' => $courseId]);
    }
}
