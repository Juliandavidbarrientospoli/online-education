<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Inscription;
use Illuminate\Support\Facades\Auth;

class UserCourses extends Component
{
    public $inscriptions;

    /**
     * Método de ciclo de vida que se ejecuta al montar el componente.
     * Carga las inscripciones del usuario actual.
     *
     * @return void
     */
    public function mount()
    {
        $this->inscriptions = Inscription::with('course')
            ->where('user_id', Auth::id())
            ->get();
    }

    /**
     * Renderiza la vista del componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.user-courses');
    }
}
