<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CategoriaController;

// Redirección a la vista de login
Route::get('/', function () {
    return view('auth.login');
});

// Vista principal del dashboard (protegida con middleware)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    // Rutas del perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD para artículos
    Route::resource('articulos', ArticuloController::class);

    // Ruta para el buscador en tiempo real de artículos
    Route::get('/articulos/filter', [ArticuloController::class, 'filter'])->name('articulos.filter');

    // CRUD para entradas
    Route::resource('entradas', EntradaController::class);

    // Rutas para ventas
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/{id}/ticket', [VentaController::class, 'generarTicket'])->name('ventas.ticket');

    // Ruta para crear una salida (venta)
    Route::get('/salida', function () {
        return view('ventas.create');
    })->name('salida');

    // Ruta para almacenar una nueva categoría
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
});

// Rutas de autenticación generadas automáticamente
require __DIR__.'/auth.php';
