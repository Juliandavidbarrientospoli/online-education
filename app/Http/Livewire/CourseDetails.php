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
