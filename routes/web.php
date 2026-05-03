<?php

use App\Http\Controllers\PostVoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecoverPasswordController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $communities = \App\Models\Community::withCount('users')->get();
        $posts = \App\Models\Post::with(['user', 'communities', 'votes'])->latest()->get();

        return view('dashboard', compact('communities', 'posts'));
    })->name('dashboard');

    // Rutas para perfiles
    // Ruta anterior que manejaba el mostrado de los perfiles, des-comentar en caso de mal funcionamiento y regresar a lo anterior
    // Route::get('/perfil', fn() => view('perfil'))->name('perfil');

    // Nueva ruta experimental
    Route::get('/perfil', function () {
        $user = Auth::user();
        $posts = $user->posts()
            ->with('votes')
            ->latest()
            ->get();

        $postsCount = $user->posts()->count();
        $likesCount = \App\Models\PostVote::whereIn('post_id', $user->posts()->pluck('id'))
            ->where('vote', 1)
            ->count();
        $commentsCount = $user->comments()->count();

        return view('perfil', compact('posts', 'postsCount', 'likesCount', 'commentsCount'));
    })->name('perfil');

    Route::patch('/perfil', [ProfileController::class, 'update'])->name('perfil.update');
    Route::patch('/perfil/password', [ProfileController::class, 'updatePassword'])->name('perfil.password');

    // Perfil público de otros usuarios
    Route::get('/perfil/{username}', [ProfileController::class, 'showPublic'])->name('perfil.show');

    // Communities and Posts
    Route::post('/communities', [CommunityController::class, 'store'])->name('communities.store');
    Route::post('/communities/{community}/add-admin', [CommunityController::class, 'addAdmin'])->name('communities.addAdmin');

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Rutas para manejar los posts de los usuarios
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('auth');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    // Funciones experimentales
    Route::post('/posts/{post}/vote', [PostVoteController::class, 'vote'])->name('posts.vote');
});

// Recuperar contrasenas
Route::get('/recuperar', [RecoverPasswordController::class, 'show'])->name('recover.show');
Route::post('/recuperar', [RecoverPasswordController::class, 'findUser'])->name('recover.find');
Route::post('/recuperar/reset', [RecoverPasswordController::class, 'reset'])->name('recover.reset');


require __DIR__.'/auth.php';
