<?php

namespace App\Services;

use App\Models\User; // Asegúrate de importar el modelo User
use Illuminate\Support\Facades\Auth;

class TokenService
{
    /**
     * Intenta autenticar al usuario y generar un token de acceso.
     *
     * @param array $credentials
     * @return string|null
     */
    public function createToken(array $credentials)
    {
        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Asegúrate de que esto retorne un usuario válido

            // Generar y retornar el token
            return $user->createToken('YourAppName')->plainTextToken; // Aquí es donde se usa el modelo User
        }

        // Si la autenticación falla, retorna null
        return null;
    }
}
