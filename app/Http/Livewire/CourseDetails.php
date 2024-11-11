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
    public $completedVideos = [];

    /**
     * Inicializa el componente cargando los datos del curso.
     *
     * @param int $courseId El ID del curso.
     */
    public function mount($courseId)
    {
        $this->loadCourseData($courseId);
    }

    /**
     * Carga los datos del curso, incluyendo videos, comentarios y likes.
     * También actualiza la lista de videos completados por el usuario.
     *
     * @param int $courseId El ID del curso.
     * @return void
     */
    public function loadCourseData($courseId)
    {
        $this->course = Course::with([
            'videos.comments.user',
            'videos.likes'
        ])->findOrFail($courseId);

        $this->completedVideos = Auth::user()->videos()
            ->wherePivot('completed', true)
            ->pluck('videos.id')
            ->toArray();
    }

    /**
     * Añade un nuevo comentario a un video específico.
     *
     * @param int $videoId El ID del video al que se añade el comentario.
     * @return void
     */
    public function addComment($videoId)
    {
        $this->validate(['newComment' => 'required|string|max:500']);

        Comment::create([
            'video_id' => $videoId,
            'user_id' => Auth::id(),
            'content' => $this->newComment,
            'approved' => true,
        ]);

        $this->newComment = '';
        $this->loadCourseData($this->course->id); // Refresca los datos del curso para actualizar comentarios
    }

    /**
     * Alterna el "like" de un usuario en un video.
     * Si el usuario ya le ha dado "like", lo quita; si no, lo añade.
     *
     * @param int $videoId El ID del video al que se aplica el "like".
     * @return void
     */
    public function toggleLike($videoId)
    {
        $like = Like::where('video_id', $videoId)->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create(['video_id' => $videoId, 'user_id' => Auth::id()]);
        }

        $this->loadCourseData($this->course->id); // Refresca los datos del curso para actualizar likes
    }

    /**
     * Marca un video como completado para el usuario actual.
     * Actualiza el progreso del curso.
     *
     * @param int $videoId El ID del video a marcar como completado.
     * @return void
     */
    public function markVideoAsCompleted($videoId)
    {
        Auth::user()->videos()->syncWithoutDetaching([$videoId => ['completed' => true]]);
        $this->completedVideos[] = $videoId;
        $this->updateCourseProgress();
    }

    /**
     * Calcula y actualiza el progreso del curso para el usuario actual.
     *
     * @return void
     */
    public function updateCourseProgress()
    {
        $totalVideos = $this->course->videos->count();
        $completedVideos = count($this->completedVideos);
        $progress = $totalVideos > 0 ? ($completedVideos / $totalVideos) * 100 : 0;

        $inscription = Auth::user()->inscriptions()
            ->where('course_id', $this->course->id)
            ->first();

        if ($inscription) {
            $inscription->update(['progress' => $progress]);
        }
    }

    /**
     * Extrae el ID de un video de YouTube desde su URL.
     *
     * @param string $url La URL del video de YouTube.
     * @return string|null El ID del video de YouTube o null si no es válido.
     */
    public function getYouTubeIdFromUrl($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        $parsedUrl = parse_url($url);

        if (isset($parsedUrl['host']) && strpos($parsedUrl['host'], 'youtube.com') !== false) {
            parse_str($parsedUrl['query'], $queryParams);
            return $queryParams['v'] ?? null;
        }

        return null;
    }

    /**
     * Renderiza el componente de detalles del curso.
     *
     * @return \Illuminate\View\View La vista de detalles del curso.
     */
    public function render()
    {
        return view('livewire.course-details');
    }
}
