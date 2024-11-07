<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;

class VideoController extends Controller
{
    /**
     * Lista los videos de un curso específico.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Course $course)
    {
        $videos = $course->videos()->with('category')->get();
        return response()->json($videos);
    }
}
