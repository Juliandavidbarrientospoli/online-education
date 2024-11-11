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

    public function mount($courseId)
    {
        $this->loadCourseData($courseId);
    }

    public function loadCourseData($courseId)
    {
        $this->course = Course::with([
            'videos.comments.user',
            'videos.likes'
        ])->findOrFail($courseId);

        // Actualiza la lista de videos completados por el usuario actual
        $this->completedVideos = Auth::user()->videos()
            ->wherePivot('completed', true)
            ->pluck('videos.id')
            ->toArray();
    }

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

    public function markVideoAsCompleted($videoId)
    {
        Auth::user()->videos()->syncWithoutDetaching([$videoId => ['completed' => true]]);
        $this->completedVideos[] = $videoId;
        $this->updateCourseProgress();
    }

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

    public function render()
    {
        return view('livewire.course-details');
    }
}
