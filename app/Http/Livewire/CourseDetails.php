<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class CourseDetails extends Component
{
    public $course;
    public $newComment;

    public function mount($courseId)
    {
        $this->course = Course::with(['videos.comments.user', 'videos.likes'])->findOrFail($courseId);
    }

    public function addComment($videoId)
    {
        $this->validate([
            'newComment' => 'required|string|max:500',
        ]);

        Comment::create([
            'video_id' => $videoId,
            'user_id' => Auth::id(),
            'content' => $this->newComment,
            'approved' => true, // Cambia esto según tu lógica de aprobación
        ]);

        $this->newComment = ''; // Limpiar campo de comentario
        $this->mount($this->course->id); // Recargar comentarios
    }


    public function getYouTubeIdFromUrl($url)
    {
        // Verifica si la URL es válida
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return null; // Si no es una URL válida, devuelve null
        }

        // Extrae los componentes de la URL
        $parsedUrl = parse_url($url);

        // Verifica si la URL proviene de YouTube
        if (isset($parsedUrl['host']) && strpos($parsedUrl['host'], 'youtube.com') !== false) {
            // Extrae el parámetro 'v' (ID del video) de la URL
            parse_str($parsedUrl['query'], $queryParams);

            // Devuelve el ID del video si existe
            return isset($queryParams['v']) ? $queryParams['v'] : null;
        }

        // Si no es una URL de YouTube, devuelve null
        return null;
    }


    public function toggleLike($videoId)
    {
        $like = Like::where('video_id', $videoId)->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'video_id' => $videoId,
                'user_id' => Auth::id(),
            ]);
        }

        $this->mount($this->course->id); // Recargar likes
    }

    public function render()
    {
        return view('livewire.course-details');
    }
}
