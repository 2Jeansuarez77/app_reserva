<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SociosController;
use App\Http\Controllers\ReservasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'socios'], function()
{
    Route::get('', [SociosController::class, 'index'])->name('socio.index');
    Route::get('getSocios', [SociosController::class, 'getSocios'])->name('socio.getSocios');
    Route::post('create',  [SociosController::class, 'store'])->name('socio.create');   
    Route::delete('eliminarSocio/{id?}',  [SociosController::class, 'eliminarSocio'])->name('socio.eliminar');   
    Route::put('actualizarSocio/{id?}',  [SociosController::class, 'actualizarSocio'])->name('socio.actualizar');    
});

Route::group(['prefix' => ''], function()
{
    Route::get('', [ReservasController::class, 'index'])->name('reserva.index');  
    Route::get('getReservas', [ReservasController::class, 'getReservas'])->name('reserva.getReservas');
    Route::post('create',  [ReservasController::class, 'store'])->name('reserva.create');   
    Route::delete('eliminarReserva/{id?}',  [ReservasController::class, 'eliminarReserva'])->name('reserva.eliminar');   
    Route::put('actualizarReserva/{id?}',  [ReservasController::class, 'actualizarReserva'])->name('reserva.actualizar');
    Route::get('diponibleReserva/{fila?}/{columna?}',  [ReservasController::class, 'estaDisponible'])->name('reserva.disponible');


});
