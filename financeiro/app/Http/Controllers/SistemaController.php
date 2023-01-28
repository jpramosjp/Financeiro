<?php

namespace App\Http\Controllers;

use App\Repositories\ReceitasRepo;
use App\Repositories\DespesaRepo;
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
        $despeRepo = new DespesaRepo;
        $menu = Menu::query()
        ->orderBy('codigo')
        ->get();
        $nomeAcesso = $usuario->nome;
        $imagemUsuario = !empty($usuario->imagem_usuario) ?" <img src='" . $usuario->imagem_usuario . "' alt='' width='32' height='32' class='rounded-circle me-2'>" : '<i class="fa-solid fa-user me-2"></i>';

        $retornoReceitas = $receitasRepo->receitasUsuario($usuario->codigo);
        $retornoDespesa = $despeRepo->despesaUsuario($usuario->codigo);
        $totalReceita = $totalDespesa = 0.00;
        if(!empty($retornoReceitas) && !empty($retornoDespesa)) {
            foreach($retornoReceitas as $dados) {
                $totalReceita += $dados->valor;
                $tiposReceitas[$dados->tipo_receita] = $dados->quantidade_receita; 
            }
            foreach($retornoDespesa as $dados) {
                $totalDespesa += $dados->valor;
                $tipoDespesa[$dados->tipo_despesa] = [$dados->quantidade_despesa, $dados->cor];
            }
        }
        $porcentagemDespesaReceita = round(($totalDespesa * 100)/ $totalReceita, 2);
        $totalReceita = number_format($totalReceita, 2, ',', '.');
        $totalDespesa = number_format($totalDespesa, 2, ',', '.');
        
        return view("sistema.index", compact("nomeAcesso", "imagemUsuario", "menu", "totalReceita", 'tiposReceitas', "totalDespesa", "tipoDespesa", "porcentagemDespesaReceita"));
    }
}
