<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;

class CourseSearch extends Component
{
    public $categories;
    public $age_groups = ['5-8', '9-13', '14-16', '16+'];
    public $searchTerm = '';
    public $category_id = '';
    public $age_group = '';

    /**
     * Método de ciclo de vida que se ejecuta al montar el componente.
     * Carga las categorías disponibles.
     *
     * @return void
     */
    public function mount()
    {
        $this->categories = Category::all();
    }

    /**
     * Renderiza la vista del componente con los cursos filtrados.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $query = Course::query();

        if ($this->searchTerm) {
            $query->where('title', 'like', '%' . $this->searchTerm . '%');
        }

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        if ($this->age_group) {
            $query->where('age_group', $this->age_group);
        }

        $courses = $query->with('category')->get();

        return view('livewire.course-search', compact('courses'));
    }
}
