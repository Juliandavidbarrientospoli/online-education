<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Inscription;

class AdminUserProgress extends Component
{
    public $users;

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        // Carga solo los usuarios con el rol 'user'
        $this->users = User::role('user')
            ->with(['inscriptions.course.videos'])
            ->get();
    }

    public function updateProgress($inscriptionId)
    {
        $inscription = Inscription::find($inscriptionId);
        if ($inscription) {
            $inscription->refresh();
        }
    }

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
