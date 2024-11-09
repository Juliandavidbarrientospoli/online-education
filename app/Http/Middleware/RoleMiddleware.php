<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Verifica si el usuario tiene el rol requerido
        if (!Auth::user() || !Auth::user()->hasRole($role)) {
            // Si no tiene el rol, redirige al usuario a otra página
            return redirect('/'); // O cualquier otra ruta
        }

        return $next($request);
    }
}
