<?php

namespace App\Livewire\Actions;

use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        auth()->logout(); // Cierra la sesión
        return redirect('/login'); // Redirige al login después de cerrar sesión
    }

    public function render()
    {
        return view('livewire.actions.logout');
    }
}
