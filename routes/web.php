<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecoverPasswordController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/perfil', fn() => view('perfil'))->name('perfil');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('perfil.update');
    Route::patch('/perfil/password', [ProfileController::class, 'updatePassword'])->name('perfil.password');
});

// Recuperar contrasenas
Route::get('/recuperar', [RecoverPasswordController::class, 'show'])->name('recover.show');
Route::post('/recuperar', [RecoverPasswordController::class, 'findUser'])->name('recover.find');
Route::post('/recuperar/reset', [RecoverPasswordController::class, 'reset'])->name('recover.reset');


require __DIR__.'/auth.php';