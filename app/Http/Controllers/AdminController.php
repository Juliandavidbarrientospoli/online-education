<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {

        $this->middleware('role:admin');
    }

    public function index()
    {
        return view('admin.index');
    }
}
