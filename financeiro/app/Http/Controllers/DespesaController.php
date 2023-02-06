<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Menucontroller;
use App\Models\Despesa;
use App\Repositories\DespesaRepo;
use App\Repositories\MesesRepo;
use Exception;
use App\Http\Controllers\SessaoController;

class DespesaController extends Controller
{
    public function index(Request $request) {
        $despesaRepo = new DespesaRepo;
        $mesesRepo = new MesesRepo;
        $menu = Menucontroller::montarMenu($request);
        $usuario = Menucontroller::dadosUsuario($request);
        $mensagem = !empty($request->session()->get('mensagem')) ? $request->session()->get('mensagem') : '';
        $classe = !empty($request->session()->get("classe")) ? $request->session()->get("classe") : '';
        $display = !empty($request->session()->get('display')) ? $request->session()->get("display") : 'none';
        $nomePagina = "Controle de Receita";
        $listaDespesa = $despesaRepo->tipoDespesa();
        $periodo = !empty($request->session()->get('periodo')) ? $request->session()->get('periodo') :\Carbon\Carbon::now()->format('Y-m-d');
        $periodoMes = $mesesRepo->buscaPeriodoMes("'" . $periodo . "'");
        $todasDespesa = $despesaRepo->despesaUsuario($usuario->codigo, "'" . $periodoMes[0]->inicio . "' AND '" . $periodoMes[0]->fim . "' ");
        return view('sistema.despesa', compact("nomePagina", "usuario", "menu", "listaDespesa", "todasDespesa", 'mensagem', 'classe', 'display','periodo','periodoMes'));
    }

    public function atualizarDespesa(Request $request) {
        try {
            $despesaRepo = new DespesaRepo;
            $dados = $request->all();
            $params = [
                "codigo" => $dados['codigo'],
                "usuario" => $dados['usuario'],
                "tipo_despesa" => $dados['tipoDespesa'],
                'data_vencimento' => empty($dados['dataVencimento']) ? date('Y-m-d') : implode("-", array_reverse(explode("/", $dados['dataVencimento']))),
                "nome_despesa" => $dados['nomeDespesa'],
                "valor" => empty($dados['valor']) ? 0.0  : str_replace(",", ".", $dados['valor'])
            ]; 
            
             if($despesaRepo->criarOuAtualizar($params) === false) {
                throw new Exception();
             };
    
    
            return response()->json(['sucesso'=> 1,'mensagem'=>'Foi atualizado com o sucesso', 'classe' => 'alert-success']);
        } catch (Exception $e) {
            return response()->json(['sucesso'=> 0,'mensagem'=>'Houve um erro ao atualizar', 'classe' => 'alert-danger']);
        }
    }

    public function destroy(Despesa $codigo, Request $request)
    {
        
       $codigo->delete();
       $parametroMensagem = [
        "mensagem" => "Deletado com sucesso",
        "classe" => "alert-success",
        "display" => "block"
        ];

        SessaoController::mensagemSessao($request, $parametroMensagem);
        return redirect()->route('controle_despesa');
    }
    public function inserirDespesa(Request $request) {
        $despesaRepo = new DespesaRepo;
        $mesesRepo = new MesesRepo;
        $dados = $request->all();
        $dados['valor_despesa'] = str_replace(",",".", $dados['valor_despesa']);
        $dados['data_vencimento'] = implode("-", array_reverse(explode("/", $dados['data_vencimento'])));
        if(!$mesesRepo->buscaPeriodoMes("'" . $dados['data_vencimento'] . "'")) {
            $parametroMensagem = [
                "mensagem" => "Data de vencimento inválida",
                "classe" => "alert-danger",
                "display" => "block"
            ];
        
            SessaoController::mensagemSessao($request, $parametroMensagem);
            return redirect()->route('controle_despesa');
        }
        if(empty($dados['nome_despesa'])) {
            $parametroMensagem = [
                "mensagem" => "Nome da despesa está vazio",
                "classe" => "alert-danger",
                "display" => "block"
            ];
        
            SessaoController::mensagemSessao($request, $parametroMensagem);
            return redirect()->route('controle_despesa');
        }
        if(empty($dados['valor_despesa']) || $dados['valor_despesa'] == 0.00) {
            $parametroMensagem = [
                "mensagem" => "Nome da despesa está vazio",
                "classe" => "alert-danger",
                "display" => "block"
            ];
        
            SessaoController::mensagemSessao($request, $parametroMensagem);
            return redirect()->route('controle_despesa');
        }
        $parametrosInserir = [
        "usuario" => $dados['usuario_despesa'],
        "tipo_despesa" => $dados['tipo_despesa'],
        "nome_despesa" => $dados['nome_despesa'] ,
        "valor" => $dados['valor_despesa'],
        'data_vencimento' => $dados['data_vencimento']
        ];
        
        $retorno = $despesaRepo->criarOuAtualizar($parametrosInserir);

        $parametroMensagem = [
            "mensagem" => "Criado com sucesso",
            "classe" => "alert-success",
            "display" => "block"
        ];
    
        SessaoController::mensagemSessao($request, $parametroMensagem);
        return redirect()->route('controle_despesa');
    }

    public function pesquisaDespesa(Request $request) {
        try {
            $despesaRepo = new DespesaRepo;
            $dados = $request->all();
            $periodo = "'" . $dados['dataInicio'] . " 00:00:00' AND '" . $dados['dataFinal'] . " 23:59:59'"; 
            $dadosTabela = $despesaRepo->despesaUsuario($dados['usuario'], $periodo);
            $listaDespesa = $despesaRepo->tipoDespesa();
            
    
    
            return response()->json(['sucesso'=> 1,'mensagem'=>'Foi atualizado com o sucesso', 'classe' => 'alert-success', 'dados' => $dadosTabela, "listaDespesa" => $listaDespesa]);
        } catch (Exception $e) {
            return response()->json(['sucesso'=> 0,'mensagem'=>'Houve um erro ao atualizar', 'classe' => 'alert-danger']);
        }
    }
}
