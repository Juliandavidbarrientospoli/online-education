<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Inscription;
use Illuminate\Support\Facades\Auth;

class CourseDetail extends Component
{
    public $course;
    public $isEnrolled = false;

    /**
     * Método de ciclo de vida que se ejecuta al montar el componente.
     * Carga el curso y verifica si el usuario está inscrito.
     *
     * @param int $courseId Identificador del curso.
     * @return void
     */
    public function mount($course)
    {
        $this->course = Course::findOrFail($course);
        $this->checkEnrollment();
    }

    /**
     * Verifica si el usuario actual está inscrito en el curso.
     *
     * @return void
     */
    public function checkEnrollment()
    {
        $this->isEnrolled = Inscription::where('course_id', $this->course->id)
            ->where('user_id', Auth::id())
            ->exists();
    }

    /**
     * Inscribe al usuario actual en el curso.
     *
     * @return void
     */
    public function enroll()
    {
        Inscription::create([
            'course_id' => $this->course->id,
            'user_id' => Auth::id(),
            'progress' => 0,
        ]);

        $this->isEnrolled = true;
        session()->flash('message', 'Te has inscrito en el curso exitosamente.');
    }

    /**
     * Renderiza la vista del componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.course-detail');
    }
}
