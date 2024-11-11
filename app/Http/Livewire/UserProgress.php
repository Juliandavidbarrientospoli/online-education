<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Inscription;

class UserProgress extends Component
{
    public $inscriptions;

    public function mount()
    {
        $this->loadInscriptions();
    }

    public function loadInscriptions()
    {
        $this->inscriptions = Auth::user()
            ->inscriptions()
            ->with('course')
            ->get();
    }

    public function markVideoAsCompleted($videoId)
    {
        // Lógica para marcar un video como completado

        // Actualiza el progreso en la inscripción y emite un evento de actualización
        $this->dispatchBrowserEvent('progressUpdated');
    }

    protected $listeners = ['progressUpdated' => 'loadInscriptions'];

    public function render()
    {
        return view('livewire.users.user-progress');
    }
}
