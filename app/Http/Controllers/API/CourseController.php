<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Lista todos los cursos disponibles.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $courses = Course::with('category')->get();
        return response()->json($courses);
    }

    /**
     * Busca cursos por título, categoría y rango de edad.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = Course::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('age_group')) {
            $query->where('age_group', $request->age_group);
        }
        $courses = $query->with('category')->get();

        //Verificamos si la colección $courses está vacía
        if ($courses->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron cursos que coincidan con los criterios de búsqueda.'
            ], 404);
        }

        return response()->json($courses);
    }
}
