<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use Livewire\WithPagination;

class CourseIndex extends Component
{
    use WithPagination;

    public $categories;
    public $ageGroups = ['5-8', '9-13', '14-16', '16+'];
    public $selectedCategory = '';
    public $selectedAgeGroup = '';
    public $searchTerm = '';
    public $viewStyle = 'grid'; // grid o list
    protected $queryString = [
        'searchTerm' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'selectedAgeGroup' => ['except' => ''],
    ];

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['searchTerm', 'selectedCategory', 'selectedAgeGroup'])) {
            $this->resetPage();
        }
    }

    public function toggleView($style)
    {
        $this->viewStyle = $style;
    }

    public function render()
    {
        $query = Course::query()
            ->with('category') // Eager loading para mejorar la performance
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->when($this->selectedAgeGroup, function ($query) {
                $query->where('age_group', $this->selectedAgeGroup);
            })
            ->when($this->searchTerm, function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('title', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->orderBy('created_at', 'desc');

        $courses = $query->paginate(9);

        return view('livewire.course-index', [
            'courses' => $courses
        ]);
    }
}
