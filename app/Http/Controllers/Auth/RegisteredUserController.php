<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
{
    $avatars = collect(glob(public_path('avatars/*.png')))
        ->map(fn($path) => basename($path))
        ->values()
        ->toArray();

    $marcos = collect(glob(public_path('marcos/*.png')))
        ->map(fn($path) => basename($path))
        ->values()
        ->toArray();

    return view('auth.register', compact('avatars', 'marcos'));
}

public function store(Request $request): RedirectResponse
{
    
    $request->validate([
        'name'     => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'min:3', 'max:20', 'unique:users,username', 'regex:/^[a-zA-Z0-9_]+$/'],
        'email'    => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/@.+\.tecmm\.edu\.mx$/'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'avatar'   => ['nullable', 'string'],
        'marco'    => ['nullable', 'string'],
        'security_question' => ['required', 'string'],
        'security_answer'   => ['required', 'string', 'min:2'],
    ], [
        'email.regex'     => 'Solo se permiten correos institucionales (@*.tecmm.edu.mx).',
        'username.unique' => 'Ese username ya está en uso.',
        'username.regex'  => 'Solo letras, números y guión bajo (_).',
        'username.min'    => 'El username debe tener mínimo 3 caracteres.',
    ]);

    $user = User::create([
        'name'     => $request->name,
        'username' => $request->username,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'avatar'   => $request->avatar ?? 'avatar_default.png',
        'marco'    => $request->marco,
        'security_question' => $request->security_question,
        'security_answer'   => strtolower(trim($request->security_answer)),
    ]);

    Auth::login($user);

    return redirect('/dashboard');
}
}