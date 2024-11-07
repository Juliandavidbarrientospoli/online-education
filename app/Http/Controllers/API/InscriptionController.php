<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Course;

class InscriptionController extends Controller
{
    /**
     * Inscribe al usuario autenticado en un curso.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Course $course)
    {
        $user = auth()->user();

        if (Inscription::where('course_id', $course->id)->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Ya estás inscrito en este curso'], 400);
        }

        Inscription::create([
            'course_id' => $course->id,
            'user_id' => $user->id,
            'progress' => 0,
        ]);

        return response()->json(['message' => 'Inscripción exitosa'], 201);
    }

    /**
     * Actualiza el progreso de un usuario en un curso.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Inscription $inscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProgress(Request $request, Inscription $inscription)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        // Verificar que la inscripción pertenezca al usuario autenticado
        if ($inscription->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $inscription->progress = $request->progress;
        $inscription->save();

        return response()->json(['message' => 'Progreso actualizado']);
    }
}
