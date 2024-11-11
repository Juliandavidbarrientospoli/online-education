<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Constructor que aplica un middleware para asegurar que solo los administradores puedan acceder.
     * Verifica que el usuario tenga el rol de 'admin' antes de permitir el acceso.
     */
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Muestra la vista principal del panel de administración.
     *
     * @return \Illuminate\View\View La vista de la página de administración.
     */
    public function index()
    {
        return view('admin.index');
    }
}
