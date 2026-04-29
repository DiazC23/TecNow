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
        $request->validate([
            'community_id' => 'required|exists:communities,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Post::create([
            'community_id' => $request->community_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Publicación creada exitosamente.');
    }

    public function destroy(Post $post)
    {
        $community = $post->community;
        $isAuthor = $post->user_id === Auth::id();
        $isForumAdmin = $community->users()->where('user_id', Auth::id())->wherePivot('role', 'admin')->exists();
        $isGlobalAdmin = Auth::user()->global_role === 'admin';

        if (!$isAuthor && !$isForumAdmin && !$isGlobalAdmin) {
            abort(403, 'No tienes permisos para borrar esta publicación.');
        }

        $post->delete();

        return back()->with('success', 'Publicación eliminada.');
    }
}
