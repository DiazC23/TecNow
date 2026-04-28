<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RecoverPasswordController extends Controller
{
    public function show()
    {
        return view('auth.recover');
    }

    public function findUser(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->security_question) {
            return back()->withErrors(['email' => 'No encontramos una cuenta con ese correo.']);
        }

        return view('auth.recover-answer', [
            'email'    => $request->email,
            'question' => $user->security_question,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'answer'   => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['answer' => 'Cuenta no encontrada.']);
        }

        if (strtolower(trim($request->answer)) !== $user->security_answer) {
            return back()->withErrors(['answer' => 'Respuesta incorrecta.'])->withInput();
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('login')->with('status', '¡Contraseña actualizada! Ya puedes iniciar sesión.');
    }
}