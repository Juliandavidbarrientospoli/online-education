<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Inscription;

class CourseShow extends Component
{
    public $course;
    public $userIsEnrolled = false;

    public function mount($course)
    {
        $this->course = Course::findOrFail($course);
        $this->userIsEnrolled = Inscription::where('course_id', $this->course->id)
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function render()
    {
        return view('livewire.course-show');
    }
}
