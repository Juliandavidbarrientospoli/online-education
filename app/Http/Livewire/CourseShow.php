<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Inscription;

class CourseShow extends Component
{
    public $course;
    public $userIsEnrolled = false;

    /**
     * Inicializa el componente cargando la información del curso
     * y verifica si el usuario está inscrito en el curso.
     *
     * @param int $course El ID del curso que se mostrará.
     * @return void
     */
    public function mount($course)
    {
        // Carga el curso especificado o devuelve un error 404 si no existe
        $this->course = Course::findOrFail($course);

        // Verifica si el usuario autenticado está inscrito en el curso
        $this->userIsEnrolled = Inscription::where('course_id', $this->course->id)
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * Renderiza la vista del componente.
     *
     * @return \Illuminate\View\View La vista del componente que muestra los detalles del curso.
     */
    public function render()
    {
        return view('livewire.course-show');
    }
}
