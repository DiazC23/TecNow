<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title'   => $validated['title'],
            'content' => $validated['content'],
        ]);

        // Si en el futuro viene un community_id (desde la vista de una comunidad):
        // $post->communities()->attach($request->community_id);

        return redirect()->route('perfil')->with('success', 'Publicación creada exitosamente.');
    }

    public function destroy(Post $post)
    {
        // Solo el autor puede eliminar
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return back()->with('success', 'Publicación eliminada.');
    }

    // Funciones experimentales
    public function create()
    {
        $communities = \App\Models\Community::all();
        return view('posts.create', compact('communities'));
    }

    public function edit(Post $post)
    {
        // Solo el autor puede editar
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Solo el autor puede editar
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($validated);

        return redirect()->route('perfil')->with('success', 'Publicación actualizada.');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'communities', 'votes']);
        $communities = \App\Models\Community::withCount('users')->get();

        // Comentarios de primer nivel con sus replies y votos
        $comments = $post->comments()
            ->whereNull('parent_id')
            ->with(['user', 'votes', 'replies.user', 'replies.votes'])
            ->latest()
            ->get();

        return view('posts.show', compact('post', 'communities', 'comments'));
    }

    public function popular()
    {
        $communities = Community::withCount('users')->get();
        $posts = Post::with(['user', 'communities', 'votes'])
            ->orderByDesc('hot_score')
            ->get();

        return view('popular', compact('communities', 'posts'));
    }

    public function trending()
    {
        $communities = Community::withCount('users')->get();
        $posts = Post::with(['user', 'communities', 'votes'])
            ->where('created_at', '>=', now()->subHours(48))
            ->orderByDesc('hot_score')
            ->get();

        return view('popular', compact('communities', 'posts'));
    }
}
