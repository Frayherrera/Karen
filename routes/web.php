<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\ArticuloController;

Route::resource('articulos', ArticuloController::class);


require __DIR__.'/auth.php';

use App\Http\Controllers\EntradaController;
use App\Http\Controllers\VentaController;

Route::post('/entradas', [EntradaController::class, 'store'])->name('entradas.store');
// Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
Route::get('/entrada', function () {
    return view('entrada');
})->name('entrada');
