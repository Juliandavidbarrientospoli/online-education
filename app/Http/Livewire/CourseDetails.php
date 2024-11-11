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
    public $courseId;

    public function mount($courseId)
    {
        $this->courseId = $courseId;
        $this->loadCourseData(); // Cargar datos al montar
    }

    public function loadCourseData()
    {
        $this->course = Course::with(['videos.comments.user', 'videos.likes'])->find($this->courseId);

        if (!$this->course) {
            abort(404, 'Curso no encontrado');
        }
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
            'approved' => true,
        ]);

        $this->newComment = '';
        $this->loadCourseData(); // Recargar datos
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

        $this->loadCourseData(); // Recargar datos
    }

    public function markVideoAsCompleted($videoId)
    {
        Auth::user()->videos()->syncWithoutDetaching([$videoId => ['completed' => true]]);
        $this->updateCourseProgress();
        $this->loadCourseData(); // Recargar datos
    }

    public function updateCourseProgress()
    {
        $totalVideos = $this->course->videos->count();
        $completedVideos = Auth::user()->videos()
            ->wherePivot('completed', true)
            ->where('course_id', $this->course->id)
            ->count();

        $progress = $totalVideos > 0 ? ($completedVideos / $totalVideos) * 100 : 0;
        $inscription = Auth::user()->inscriptions()->where('course_id', $this->course->id)->first();

        if ($inscription) {
            $inscription->update(['progress' => $progress]);
        }
    }

    public function render()
    {
        return view('livewire.course-details');
    }
}
