<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Almacena un nuevo comentario para un video.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Video $video)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'video_id' => $video->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'approved' => false,
        ]);

        return response()->json(['message' => 'Comentario enviado para aprobación'], 201);
    }
}
