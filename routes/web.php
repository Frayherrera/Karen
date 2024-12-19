<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloController;

// Redirección a la vista de login
Route::get('/', function () {
    return view('auth.login');
});

// Vista principal del dashboard (protegida con middleware)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas protegidas para el perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CRUD para artículos
Route::resource('articulos', ArticuloController::class);

// Ruta para el buscador en tiempo real de artículos
Route::get('/articulos/filter', [ArticuloController::class, 'filter'])->name('articulos.filter');

// Rutas de autenticación generadas automáticamente
require __DIR__.'/auth.php';
