<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\JuegoController;

Route::resource('usuarios', UsuarioController::class);

Route::get('registro', [UsuarioController::class, 'mostrarRegistro'])->name('registro');
Route::get('ingreso', [UsuarioController::class, 'mostrarIngreso'])->name('ingreso');
Route::post('/crear_usuario', [UsuarioController::class, 'store'])->name('crear_usuario');
Route::post('/ingresar_usuario', [UsuarioController::class, 'login'])->name('ingresar_usuario');
Route::get('/ver_grupo/{codigo}', [JuegoController::class, 'verGrupo'])->name('ver_grupo');
Route::get('/ver_oculto/{codigo}', [JuegoController::class, 'verOculto'])->name('ver_oculto');

Route::middleware('customAuth')->group(function () {
    // Rutas protegidas aquí
    Route::get('/home', [JuegoController::class, 'index'])->name('home');
    Route::get('/salir', [UsuarioController::class, 'salir'])->name('salir');
    Route::post('/crea_sala', [JuegoController::class, 'store'])->name('crea_sala');
    Route::get('/unirme/{id}', [JuegoController::class, 'unirme'])->name('unirme');
    Route::post('/sorteo/{id}', [JuegoController::class, 'sorteo'])->name('sorteo');

});

Route::get('/', function () {
    return view('welcome');
});
