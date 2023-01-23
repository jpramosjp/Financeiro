<?php

use App\Http\Controllers\UsuarioController;
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

Route::get('/', [UsuarioController::class, 'index'])
    ->name('login');

Route::get('/cadastro', [UsuarioController::class,'cadastro'])
    ->name('form_cadastro_usuario');

Route::post('/cadastro',[UsuarioController::class, 'criarUsuario']);
