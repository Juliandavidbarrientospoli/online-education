<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario en la aplicación.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP con los datos del usuario.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con los datos del usuario registrado y el token de autenticación.
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        $token = $user->createToken('appToken')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    /**
     * Inicia sesión y genera un token de autenticación para el usuario.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP con las credenciales del usuario.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con los datos del usuario autenticado y el token de autenticación.
     * @throws \Illuminate\Validation\ValidationException Si las credenciales son incorrectas.
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('appToken')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    /**
     * Cierra la sesión del usuario autenticado, eliminando sus tokens.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP del usuario.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON confirmando la salida del usuario.
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
