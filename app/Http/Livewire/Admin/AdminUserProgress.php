<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Inscription;

class AdminUserProgress extends Component
{
    public $users;

    /**
     * Método de inicialización para cargar los usuarios.
     */
    public function mount()
    {
        $this->loadUsers();
    }

    /**
     * Carga los usuarios con el rol 'user' y sus inscripciones,
     * incluyendo el progreso en sus cursos y videos asociados.
     *
     * @return void
     */
    public function loadUsers()
    {
        $this->users = User::role('user')
            ->with(['inscriptions.course.videos'])
            ->get();
    }

    /**
     * Actualiza el progreso de la inscripción especificada.
     *
     * @param int $inscriptionId El ID de la inscripción a actualizar.
     * @return void
     */
    public function updateProgress($inscriptionId)
    {
        $inscription = Inscription::find($inscriptionId);
        if ($inscription) {
            $inscription->refresh();
        }
    }

    /**
     * Renderiza el componente Livewire y proporciona una lista de usuarios con sus cursos y progreso.
     *
     * @return \Illuminate\View\View La vista del componente Livewire con los datos de progreso de los usuarios.
     */
    public function render()
    {
        $users = User::role('user')
            ->whereHas('inscriptions')
            ->with(['inscriptions.course.videos'])
            ->get();

        return view('livewire.admin.admin-user-progress', [
            'users' => $users
        ]);
    }
}
