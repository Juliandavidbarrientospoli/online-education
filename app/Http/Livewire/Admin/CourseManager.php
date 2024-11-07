<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CourseManager extends Component
{
    public $courses;
    public $categories;
    public $title, $description, $age_group, $category_id;
    public $course_id;
    public $isEditing = false;

    /**
     * Reglas de validación para el formulario.
     *
     * @var array<string, mixed>
     */
    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'age_group' => 'required|in:5-8,9-13,14-16,16+',
        'category_id' => 'required|exists:categories,id',
    ];

    /**
     * Método de ciclo de vida que se ejecuta al montar el componente.
     * Carga las categorías y los cursos del administrador actual.
     *
     * @return void
     */
    public function mount()
    {
        $this->categories = Category::all();
        $this->loadCourses();
    }

    /**
     * Carga los cursos creados por el administrador actual.
     *
     * @return void
     */
    public function loadCourses()
    {
        $this->courses = Course::where('created_by', Auth::id())->get();
    }

    /**
     * Crea un nuevo curso con los datos proporcionados.
     *
     * @return void
     */
    public function createCourse()
    {
        $this->validate();

        Course::create([
            'title' => $this->title,
            'description' => $this->description,
            'age_group' => $this->age_group,
            'category_id' => $this->category_id,
            'created_by' => Auth::id(),
        ]);

        $this->resetForm();
        $this->loadCourses();
        session()->flash('message', 'Curso creado exitosamente.');
    }

    /**
     * Prepara el formulario para editar un curso existente.
     *
     * @param int $id Identificador del curso a editar.
     * @return void
     */
    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        $this->course_id = $id;
        $this->title = $course->title;
        $this->description = $course->description;
        $this->age_group = $course->age_group;
        $this->category_id = $course->category_id;
        $this->isEditing = true;
    }

    /**
     * Actualiza el curso con los datos del formulario.
     *
     * @return void
     */
    public function updateCourse()
    {
        $this->validate();

        $course = Course::findOrFail($this->course_id);
        $course->update([
            'title' => $this->title,
            'description' => $this->description,
            'age_group' => $this->age_group,
            'category_id' => $this->category_id,
        ]);

        $this->resetForm();
        $this->loadCourses();
        session()->flash('message', 'Curso actualizado exitosamente.');
    }

    /**
     * Elimina un curso existente.
     *
     * @param int $id Identificador del curso a eliminar.
     * @return void
     */
    public function deleteCourse($id)
    {
        Course::findOrFail($id)->delete();
        $this->loadCourses();
        session()->flash('message', 'Curso eliminado exitosamente.');
    }

    /**
     * Resetea los campos del formulario.
     *
     * @return void
     */
    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->age_group = '';
        $this->category_id = '';
        $this->course_id = null;
        $this->isEditing = false;
    }

    /**
     * Renderiza la vista del componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.admin.course-manager');
    }
}
