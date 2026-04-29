<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecoverPasswordController;

Route::get('/', function () {
    return redirect('/dashboard');
});

use App\Http\Controllers\CommunityController;
use App\Http\Controllers\PostController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $communities = \App\Models\Community::withCount('users')->get();
        $posts = \App\Models\Post::with(['user', 'community'])->latest()->get();
        return view('dashboard', compact('communities', 'posts'));
    })->name('dashboard');

    Route::get('/perfil', fn() => view('perfil'))->name('perfil');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('perfil.update');
    Route::patch('/perfil/password', [ProfileController::class, 'updatePassword'])->name('perfil.password');

    // Communities and Posts
    Route::post('/communities', [CommunityController::class, 'store'])->name('communities.store');
    Route::post('/communities/{community}/add-admin', [CommunityController::class, 'addAdmin'])->name('communities.addAdmin');
    
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Recuperar contrasenas
Route::get('/recuperar', [RecoverPasswordController::class, 'show'])->name('recover.show');
Route::post('/recuperar', [RecoverPasswordController::class, 'findUser'])->name('recover.find');
Route::post('/recuperar/reset', [RecoverPasswordController::class, 'reset'])->name('recover.reset');


require __DIR__.'/auth.php';