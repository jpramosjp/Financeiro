<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Menucontroller;
use App\Repositories\DinheiroRepo;
use Exception;
use App\Models\Dinheiro;
use App\Http\Controllers\SessaoController;

class DinheiroController extends Controller
{
    public function index(Request $request) {
        $menu = Menucontroller::montarMenu($request);
        $usuario = Menucontroller::dadosUsuario($request);
        $mensagem = !empty($request->session()->get('mensagem')) ? $request->session()->get('mensagem') : '';
        $classe = !empty($request->session()->get("classe")) ? $request->session()->get("classe") : '';
        $display = !empty($request->session()->get('display')) ? $request->session()->get("display") : 'none';
        $dinheiroGuardado = DinheiroRepo::dinheiroUsuario($usuario->codigo);
        return view('sistema.dinheiro', compact("usuario", "menu",'dinheiroGuardado', 'mensagem', 'classe', 'display'));
    }

    public function atualizarDinheiro(Request $request) {
        try {
           
            $dinheiroRepo = new DinheiroRepo;
            
            $dados = $request->all();
            $params = [
                "codigo" => $dados['codigo'],
                "usuario" => $dados['usuario'],
                "valor" => empty($dados['valor']) ? 0.0  : str_replace(",", ".", $dados['valor'])
            ]; 
             if($dinheiroRepo->criarOuAtualizar($params) === false) {
                throw new Exception();
             };
    
    
            return response()->json(['sucesso'=> 1,'mensagem'=>'Foi atualizado com o sucesso', 'classe' => 'alert-success']);
        } catch (Exception $e) {
            return response()->json(['sucesso'=> 0,'mensagem'=>'Houve um erro ao atualizar', 'classe' => 'alert-danger']);
        }
    }

    public function destroy(Dinheiro $codigo, Request $request)
    {
        
       $codigo->delete();
       $parametroMensagem = [
        "mensagem" => "Deletado com sucesso",
        "classe" => "alert-success",
        "display" => "block"
        ];

        SessaoController::mensagemSessao($request, $parametroMensagem);
        return redirect()->route('controle_dinheiro');
    }
    public function inserirDinheiro(Request $request) {
        $dinheiroRepo = new dinheiroRepo;
        $dados = $request->all();
        $dados['valor_dinheiro'] = str_replace(",",".", $dados['valor_dinheiro']);
    
        if(empty($dados['valor_dinheiro']) || $dados['valor_dinheiro'] == 0.00) {
            $parametroMensagem = [
                "mensagem" => "Nome da despesa está vazio",
                "classe" => "alert-danger",
                "display" => "block"
            ];
        
            SessaoController::mensagemSessao($request, $parametroMensagem);
            return redirect()->route('controle_despesa');
        }
        $parametrosInserir = [
        "usuario" => $dados['usuario_dinheiro'],
        "valor" => $dados['valor_dinheiro']
        ];
        
        $retorno = $dinheiroRepo->criarOuAtualizar($parametrosInserir);

        $parametroMensagem = [
            "mensagem" => "Criado com sucesso",
            "classe" => "alert-success",
            "display" => "block"
        ];
    
        SessaoController::mensagemSessao($request, $parametroMensagem);
        return redirect()->route('controle_dinheiro');
    }

}
