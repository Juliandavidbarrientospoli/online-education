<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    /**
     * Almacena una nueva inscripción para el usuario autenticado en un curso específico.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP con los datos de la inscripción.
     * @param int $courseId El ID del curso al que el usuario quiere inscribirse.
     * @return \Illuminate\Http\RedirectResponse Redirige a la página de detalles del curso o muestra un mensaje si ya está inscrito.
     */
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

        Inscription::create([
            'course_id' => $courseId,
            'user_id' => Auth::id(),
            'progress' => 0,
            'current_video_id' => null
        ]);

        return redirect()->route('courses.details', ['courseId' => $courseId]);
    }
}
