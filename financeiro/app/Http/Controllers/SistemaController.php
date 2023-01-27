<?php

namespace App\Http\Controllers;

use App\Repositories\ReceitasRepo;
use Illuminate\Support\Facades\Number;


use Illuminate\Http\Request;
use App\Models\Menu;

class SistemaController extends Controller
{
    public function index(Request $request) {
        $usuario = $request->session()->get('usuario');
        if(empty($usuario)) {
            return redirect()->route("login");
        }
        $receitasRepo = new ReceitasRepo;
        $menu = Menu::query()
        ->orderBy('codigo')
        ->get();
        $nomeAcesso = $usuario->nome;
        $imagemUsuario = !empty($usuario->imagem_usuario) ?" <img src='" . $usuario->imagem_usuario . "' alt='' width='32' height='32' class='rounded-circle me-2'>" : '<i class="fa-solid fa-user me-2"></i>';

        $retorno = $receitasRepo->receitasUsuario($usuario->codigo);
        $totalReceita = 0.00;
        if(!empty($retorno)) {
            foreach($retorno as $dados) {
                $totalReceita += $dados->valor;
                $tiposReceitas[$dados->tipo_receita] = $dados->quantidade_receita; 
            }
        }
        $totalReceita = number_format($totalReceita, 2, ',', '.');
        return view("sistema.index", compact("nomeAcesso", "imagemUsuario", "menu", "totalReceita", 'tiposReceitas'));
    }
}
