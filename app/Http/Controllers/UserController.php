<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('courses')->get(); // Asegúrate de que el modelo `User` tenga la relación `courses`
        return view('admin.users.index', compact('users'));
    }
}
