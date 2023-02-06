<?php

use App\Http\Controllers\DespesaController;
use App\Http\Controllers\DinheiroController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReceitasController;
use App\Models\Despesa;
use App\Models\Dinheiro;
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


Route::get('/sistema.receitas', [ReceitasController::class, 'index'])
    ->name('controle_receita');

Route::post('/sistema.receitas', [ReceitasController::class, 'inserirReceita'])
->name('inserir_receita');


Route::post('/sistema.atualizarReceita', [ReceitasController::class, 'atualizarReceita'])
    ->name('atualizar_receitas');

Route::delete('/sistema.receitas/{codigo}', [ReceitasController::class, 'destroy'])
        ->name("deletar");



Route::get('/sistema.despesa', [DespesaController::class, 'index'])
    ->name('controle_despesa');

Route::post('/sistema.atualizarDespesa', [DespesaController::class, 'atualizarDespesa'])
    ->name('atualizar_despesa');

Route::post('/sistema.inserirDespesa', [DespesaController::class, 'inserirDespesa'])
    ->name('inserir_despesa');

Route::post('/sistema.pesquisaDespesa', [DespesaController::class, 'pesquisaDespesa'])
    ->name('pesquisa_despesa');

Route::delete('/sistema.despesa/{codigo}', [DespesaController::class, 'destroy'])
    ->name("deletar_despesa");

Route::get('/sistema.dinheiro', [DinheiroController::class, 'index'])
    ->name('controle_dinheiro');

Route::post('/sistema.atualizarDinheiro', [DinheiroController::class, 'atualizarDinheiro'])
    ->name('atualizar_dinheiro');

Route::delete('/sistema.dinheiro/{codigo}', [DinheiroController::class, 'destroy'])
    ->name("deletar_dinheiro");

Route::post('/sistema.inserirDinheiro', [DinheiroController::class, 'inserirDinheiro'])
    ->name('inserir_dinheiro');