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

    protected $queryString = [
        'searchTerm' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'selectedAgeGroup' => ['except' => ''],
    ];

    #[On('refresh')]
    public function refresh()
    {
        // La función se ejecutará cuando se emita el evento 'refresh'
    }

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

    public function render()
    {
        $query = Course::query()
    ->select(['id', 'title', 'description', 'category_id', 'age_group', 'image_url']) // Incluye image_url
    ->with('category:id,name')
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

        return view('livewire.course-index', [
            'courses' => $query->paginate(8)
        ]);
    }
}
