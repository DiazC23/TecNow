<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->global_role !== 'admin') {
            abort(403, 'No tienes permiso para crear comunidades.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $community = Community::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => '💬',
            'created_by' => Auth::id(),
        ]);

        $community->users()->attach(Auth::id(), ['role' => 'admin']);

        return back()->with('success', 'Comunidad creada exitosamente.');
    }

    public function addAdmin(Request $request, Community $community)
    {
        $isAdmin = $community->users()->where('user_id', Auth::id())->wherePivot('role', 'admin')->exists();
        if (!$isAdmin && Auth::user()->global_role !== 'admin') {
            abort(403, 'No tienes permiso.');
        }

        $request->validate(['username' => 'required|exists:users,username']);
        
        $user = User::where('username', $request->username)->firstOrFail();
        
        $community->users()->syncWithoutDetaching([$user->id => ['role' => 'admin']]);

        return back()->with('success', 'Administrador añadido correctamente.');
    }
}
