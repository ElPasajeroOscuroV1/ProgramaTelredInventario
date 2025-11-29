<?php

use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MarcaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/Productos', ProductoController::class)->names('producto');
    Route::resource('/Marcas', MarcaController::class)->names('marcas');
    Route::resource('cotizaciones', CotizacionController::class)->parameters([
        'cotizaciones' => 'cotizacion'
    ]);
    Route::post('/cotizaciones/{id}/descuento', [CotizacionController::class, 'aplicarDescuento'])
    ->name('cotizaciones.aplicar_descuento');
});

require __DIR__.'/auth.php';
