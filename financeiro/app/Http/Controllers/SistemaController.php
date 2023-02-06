<?php

namespace App\Http\Controllers;

use App\Repositories\ReceitasRepo;
use App\Repositories\DespesaRepo;
use Illuminate\Support\Facades\Number;
use App\Http\Controllers\Menucontroller;
use App\Repositories\DinheiroRepo;
use App\Models\Meses;


use Illuminate\Http\Request;


class SistemaController extends Controller
{
    public function index(Request $request) {
        $usuario = Menucontroller::dadosUsuario($request);
        if(empty($usuario)) {
            return redirect()->route("login");
        }
        $mensagem = !empty($request->session()->get('mensagem')) ? $request->session()->get('mensagem') : '';
        $classe = !empty($request->session()->get("classe")) ? $request->session()->get("classe") : '';
        $display = !empty($request->session()->get('display')) ? $request->session()->get("display") : 'none';
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
        $dinheiroRepo = new DinheiroRepo;
        $menu = Menucontroller::montarMenu($request);

        $retornoReceitas = $receitasRepo->receitasUsuario($usuario->codigo);
        $retornoDespesa = $despeRepo->despesaUsuario($usuario->codigo, $periodoVencimento);
        $retornoDinheiro = $dinheiroRepo->dinheiroUsuario($usuario->codigo);
        $totalReceita = $totalDespesa = $totalDinheiroGuardado = 0.00;
        $codigoDespesa = [];
        $cadaDespesaUsuario = [];
        $tipoDespesa = [];
        $tiposReceitas = [];
        $porcentagemDespesaReceita = 0;
        if(!empty($retornoDinheiro)) {
            foreach($retornoDinheiro as $dados) {
                $totalDinheiroGuardado += $dados->valor;
            }
        }
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
            $contaRceita = $totalReceita == 0 ? 1 : $totalReceita;
            $porcentagemDespesaReceita =  round(($totalDespesa * 100)/ $contaRceita, 2);
            $totalReceita = number_format($totalReceita, 2, ',', '.');
            $totalDespesa = number_format($totalDespesa, 2, ',', '.');
            $cadaDespesaUsuario = $despeRepo->cadaDespesaUuario($usuario->codigo, implode("," ,array_unique($codigoDespesa)), $periodoVencimento);
        }
       
        
        return view("sistema.index", compact("usuario", "menu", "totalReceita", 'tiposReceitas', "totalDespesa", "tipoDespesa", "porcentagemDespesaReceita", "cadaDespesaUsuario", 'mesEscolhido', 'mesesSelect', 'mensagem', 'classe', 'display', 'totalDinheiroGuardado'));
    }


}
