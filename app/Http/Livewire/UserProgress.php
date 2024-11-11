<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class UserProgress extends Component
{
    public $inscriptions;

    public function mount()
    {
        // Obtiene las inscripciones del usuario logueado con los cursos y progreso
        $this->inscriptions = Auth::user()
            ->inscriptions()
            ->with('course')
            ->get();
    }
    // En UserProgress.php

    public function markVideoAsCompleted($videoId)

    {
        // Encuentra el video y márcalo como completado
        $video = Video::findOrFail($videoId);
        $video->update(['completed' => true]);

        // Actualiza el progreso en la inscripción
        $inscription = Auth::user()->inscriptions()->where('course_id', $video->course_id)->first();
        $inscription->updateProgress();

        // Actualiza la propiedad $inscriptions para reflejar el nuevo progreso
        $this->inscriptions = Auth::user()->inscriptions()->with('course')->get();
    }

    public function render()
    {
        return view('livewire.user-progress');
    }
}
