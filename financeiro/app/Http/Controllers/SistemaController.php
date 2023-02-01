<?php

namespace App\Http\Controllers;

use App\Repositories\ReceitasRepo;
use App\Repositories\DespesaRepo;
use Illuminate\Support\Facades\Number;
use App\Http\Controllers\Menucontroller;
use App\Models\Meses;


use Illuminate\Http\Request;


class SistemaController extends Controller
{
    public function index(Request $request) {
        $usuario = Menucontroller::dadosUsuario($request);
        if(empty($usuario)) {
            return redirect()->route("login");
        }
        $meses = Meses::get();
        $mesEscolhido = empty($request->input('mesEscolhido')) ? date('m') : $request->input('mesEscolhido');
        $mesesSelect = [];
        $periodoVencimento = '';
        foreach($meses as $dados) {
            if($mesEscolhido == date('m', strtotime($dados->inicio)) ){
                $periodoVencimento = "'" . $dados->inicio . "' AND '" . $dados->fim . "'";
            }
            $mesesSelect[] =["mes" => date('m', strtotime($dados->inicio)), "nome" => $dados->nome]; 
        }

        $receitasRepo = new ReceitasRepo;
        $despeRepo = new DespesaRepo;
        $menu = Menucontroller::montarMenu($request);

        $retornoReceitas = $receitasRepo->receitasUsuario($usuario->codigo);
        $retornoDespesa = $despeRepo->despesaUsuario($usuario->codigo, $periodoVencimento);
        $totalReceita = $totalDespesa = 0.00;
        $codigoDespesa = [];
        $cadaDespesaUsuario = [];
        $tipoDespesa = [];
        $tiposReceitas = [];
        $porcentagemDespesaReceita = 0;
        if(!empty($retornoReceitas) && !empty($retornoDespesa)) {
            foreach($retornoReceitas as $dados) {
                $totalReceita += $dados->valor;
                $tiposReceitas[$dados->tipo_receita] = $dados->quantidade_receita; 
            }
            foreach($retornoDespesa as $dados) {
                $totalDespesa += $dados->valor;
                $tipoDespesa[$dados->tipo_despesa] = [$dados->quantidade_despesa, $dados->cor];
                $codigoDespesa[]= $dados->codigo_despesa; 
            }
            $porcentagemDespesaReceita =  round(($totalDespesa * 100)/ $totalReceita, 2);
            $totalReceita = number_format($totalReceita, 2, ',', '.');
            $totalDespesa = number_format($totalDespesa, 2, ',', '.');
            $cadaDespesaUsuario = $despeRepo->cadaDespesaUuario($usuario->codigo, implode("," ,array_unique($codigoDespesa)), $periodoVencimento);
        }
       
        
        return view("sistema.index", compact("usuario", "menu", "totalReceita", 'tiposReceitas', "totalDespesa", "tipoDespesa", "porcentagemDespesaReceita", "cadaDespesaUsuario", 'mesEscolhido', 'mesesSelect'));
    }

    public function atualizar(Request $request) {
        echo 'teste';
    }
}
