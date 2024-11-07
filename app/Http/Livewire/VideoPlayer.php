<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Video;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Inscription;
use Illuminate\Support\Facades\Auth;

class VideoPlayer extends Component
{
    public $course;
    public $video;
    public $comments;
    public $content;
    public $isLiked = false;

    /**
     * Método de ciclo de vida que se ejecuta al montar el componente.
     * Carga el curso, el video y los comentarios asociados.
     *
     * @param int $courseId Identificador del curso.
     * @param int $videoId Identificador del video.
     * @return void
     */
    public function mount($course, $video)
{
    $this->course = Course::findOrFail($course);
    $this->video = Video::findOrFail($video);

    // Verificar si el usuario está inscrito en el curso
    $isEnrolled = Inscription::where('course_id', $this->course->id)
        ->where('user_id', Auth::id())
        ->exists();

    if (!$isEnrolled) {
        abort(403, 'No tienes acceso a este curso.');
    }

    $this->loadComments();
    $this->checkLike();
    }

    /**
     * Carga los comentarios aprobados del video.
     *
     * @return void
     */
    public function loadComments()
    {
        $this->comments = Comment::with('user')
            ->where('video_id', $this->video->id)
            ->where('approved', true)
            ->get();
    }

    /**
     * Agrega un nuevo comentario al video.
     *
     * @return void
     */
    public function addComment()
    {
        $this->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'video_id' => $this->video->id,
            'user_id' => Auth::id(),
            'content' => $this->content,
            'approved' => false,
        ]);

        $this->content = '';
        session()->flash('message', 'Comentario enviado para aprobación.');
    }

    /**
     * Verifica si el usuario actual ha dado like al video.
     *
     * @return void
     */
    public function checkLike()
    {
        $this->isLiked = Like::where('video_id', $this->video->id)
            ->where('user_id', Auth::id())
            ->exists();
    }

    /**
     * Da like al video actual.
     *
     * @return void
     */
    public function like()
    {
        Like::create([
            'video_id' => $this->video->id,
            'user_id' => Auth::id(),
        ]);

        $this->isLiked = true;
    }

    /**
     * Quita el like del video actual.
     *
     * @return void
     */
    public function unlike()
    {
        Like::where('video_id', $this->video->id)
            ->where('user_id', Auth::id())
            ->delete();

        $this->isLiked = false;
    }
    
    /**
     * Actualiza el progreso del usuario en el curso.
     *
     * @return void
     */
    public function updateProgress()
    {
        $inscription = Inscription::where('course_id', $this->course->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($inscription) {
            // Supongamos que cada video representa un porcentaje fijo del curso
            $totalVideos = $this->course->videos()->count();
            $completedVideos = $this->course->videos()
                ->where('id', '<=', $this->video->id)
                ->count();

            $progress = ($completedVideos / $totalVideos) * 100;

            $inscription->progress = $progress;
            $inscription->current_video_id = $this->video->id;
            $inscription->save();
        }
    }

    /**
     * Renderiza la vista del componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $this->updateProgress();
        return view('livewire.video-player');
    }
}
