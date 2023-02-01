<?php

use App\Http\Controllers\SistemaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Receitascontroller;
use App\Models\Receitas;
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

Route::post('/cadastro', [UsuarioController::class, 'criarUsuario']);

Route::post('/', [UsuarioController::class, 'logar']);

Route::get('/sistema',[SistemaController::class, 'index'])
    ->name('sistema');

Route::post('/sistema',[SistemaController::class, 'index']);

Route::post('/logout',[UsuarioController::class, 'logout'])
    ->name('logout');


Route::get('/sistema.receitas', [Receitascontroller::class, 'index'])
    ->name('controle_receita');

Route::post('/atualizar_receitas', [Receitascontroller::class, 'atualizarReceita'])
    ->name('atualizar_receitas');


Route::get('/sistema.despesa', [SistemaController::class, 'despesa'])
    ->name('controle_despesa');

Route::get('/sistema.dinheiro', [SistemaController::class, 'dinheiro'])
    ->name('controle_dinheiro');