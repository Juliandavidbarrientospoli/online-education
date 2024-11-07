<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Like;

class LikeController extends Controller
{
    /**
     * Da like a un video.
     *
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Video $video)
    {
        $user = auth()->user();

        if (Like::where('video_id', $video->id)->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Ya has dado like a este video'], 400);
        }

        Like::create([
            'video_id' => $video->id,
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Like agregado'], 201);
    }

    /**
     * Quita el like de un video.
     *
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlike(Video $video)
    {
        $user = auth()->user();

        $like = Like::where('video_id', $video->id)->where('user_id', $user->id)->first();

        if (!$like) {
            return response()->json(['message' => 'No has dado like a este video'], 400);
        }

        $like->delete();

        return response()->json(['message' => 'Like eliminado']);
    }
}
