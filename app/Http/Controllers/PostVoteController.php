<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostVote;
use Illuminate\Support\Facades\Auth;

class PostVoteController extends Controller
{
    //
    public function vote(Request $request, Post $post)
    {
        $request->validate([
            'vote' => 'required|in:1,-1',
        ]);

        $value = (int) $request->vote;

        $existing = PostVote::where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->first();

        if ($existing) {
            if ($existing->vote === $value) {
                // Mismo voto → cancela (toggle)
                PostVote::where('user_id', Auth::id())
                    ->where('post_id', $post->id)
                    ->delete();
            } else {
                // Voto contrario → actualiza con query directa
                PostVote::where('user_id', Auth::id())
                    ->where('post_id', $post->id)
                    ->update(['vote' => $value]);
            }
        } else {
            // Voto nuevo
            PostVote::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'vote'    => $value,
            ]);
        }

        return back();
    }
}
