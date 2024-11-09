<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        // Protege este controlador para que solo los administradores puedan acceder
        $this->middleware('role:admin'); // Middleware para verificar si el usuario tiene el rol de admin
    }

    public function index()
    {
        return view('admin.index');
    }
}
