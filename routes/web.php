<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CategoriaController;
use App\Models\Articulo;

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
    Route::delete('/ventas/{id}', [VentaController::class, 'destroy'])->name('ventas.destroy');
 
    // Ruta para crear una salida (venta)
    Route::get('/salida', function () {
        $articulos = Articulo::all();
        $lastId = \App\Models\Venta::max('id');
        $nextId = $lastId ? $lastId + 1 : 1;
        return view('ventas.create', compact('articulos', 'nextId'));
    })->name('salida');

    // Ruta para almacenar una nueva categoría
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');

    Route::post('/articulos/get', [ArticuloController::class, 'getArticulo'])->name('articulos.get');
    Route::get('/obtener-valor/{id}', [ArticuloController::class, 'obtenerValor']);

    Route::get('/obtener-articulo/{id}', [ArticuloController::class, 'obtenerArticulo']);

    Route::get('/obtener-articulo-por-codigo/{codigo}', [ArticuloController::class, 'obtenerArticuloPorCodigo']);

    Route::post('/ventas/cambiar-estado/{id}', [VentaController::class, 'cambiarEstado']);
});
// Rutas de autenticación generadas automáticamente
require __DIR__ . '/auth.php';