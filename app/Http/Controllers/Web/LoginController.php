<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt(['nick_name' => $request->nickname, 'password' => $request->password])) {
            // Autenticación exitosa
            return redirect()->route('home');
        }

        // Si la autenticación falla, redirigir con un error
        return back()->withErrors([
            'nickname' => 'Usuario o Contraseña Incorrectos',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Cierra la sesión del usuario

        $request->session()->invalidate(); // Invalida la sesión actual
        $request->session()->regenerateToken(); // Regenera el token CSRF para seguridad

        return redirect('/'); // Redirige al usuario a la página de inicio o cualquier otra
    }
}

