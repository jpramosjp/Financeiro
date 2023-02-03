<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Menucontroller;
use App\Models\Receitas;
use App\Repositories\ReceitasRepo;
use Exception;
use App\Http\Controllers\SessaoController;

class Receitascontroller extends Controller
{
    public function index(Request $request) {
        $receitasRepo = new ReceitasRepo;
        $menu = Menucontroller::montarMenu($request);
        $usuario = Menucontroller::dadosUsuario($request);
        $mensagem = !empty($request->session()->get('mensagem')) ? $request->session()->get('mensagem') : '';
        $classe = !empty($request->session()->get("classe")) ? $request->session()->get("classe") : '';
        $display = !empty($request->session()->get('display')) ? $request->session()->get("display") : 'none';
        $nomePagina = "Controle de Receita";
        $listaReceitas = $receitasRepo->tiposReceitas();
        $todasReceitas = $receitasRepo->receitasUsuario($usuario->codigo);
        return view('sistema.receitas', compact("nomePagina", "usuario", "menu", "listaReceitas", "todasReceitas", 'mensagem', 'classe', 'display'));
    }

    public function atualizarReceita(Request $request) {
        try {
            $receitasRepo = new ReceitasRepo;
            $dados = $request->all(); 
            $params = [
                "codigo" => $dados['codigo'],
                "usuario" => $dados['usuario'],
                "tipo_receita" => $dados['codigoReceita'],
                "descricao" => "",
                "valor" => $dados['valor']
            ]; 
            $tipoReceita = count($receitasRepo->tiposReceitas("WHERE upper(A.descricao) = upper('" . $dados['tipoReceita'] . "') ")) == 0 ? count($receitasRepo->tiposReceitas("WHERE A.codigo = ". $dados['codigoReceita'])) == 0 ? 0 : $receitasRepo->tiposReceitas("WHERE A.codigo = ". $dados['codigoReceita']) : $receitasRepo->tiposReceitas("WHERE upper(A.descricao) = upper('" . $dados['tipoReceita'] . "') ");
            $params['tipo_receita'] = isset($tipoReceita[0]->codigo) ? $tipoReceita[0]->codigo : 0;
            if(!isset($tipoReceita[0]->nome) || strtoupper($tipoReceita[0]->nome) != strtoupper($dados['tipoReceita'])) {
                $params['descricao'] = $dados['tipoReceita'];
                $params['tipo_receita'] = 0;
            }
            
          
             if($receitasRepo->criarOuAtualizar($params) === false) {
                throw new Exception();
             };
    
    
            return response()->json(['sucesso'=> 1,'mensagem'=>'Foi atualizado com o sucesso', 'classe' => 'alert-success']);
        } catch (Exception $e) {
            return response()->json(['sucesso'=> 0,'mensagem'=>'Houve um erro ao atualizar', 'classe' => 'alert-danger']);
        }
    }

    public function destroy(Receitas $codigo, Request $request)
    {
       $codigo->delete();
       $parametroMensagem = [
        "mensagem" => "Deletado com sucesso",
        "classe" => "alert-success",
        "display" => "block"
        ];

        SessaoController::mensagemSessao($request, $parametroMensagem);
        return redirect()->route('controle_receita');
    }
    public function inserirReceita(Request $request) {
        $receitasRepo = new ReceitasRepo;
        $dados = $request->all();
        $parametrosInserir = [
        "usuario" => $dados['usuario_receita'],
        "tipo_receita" => $dados['tipo_receita'] == 3 ? 0 : $dados['tipo_receita'],
        "descricao" => empty($dados['descricao_receita']) ? '' : $dados['descricao_receita'],
        "valor" => str_replace("," , ".", $dados['valor_receita']),
        'data_inserido' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ];
        
        $retorno = $receitasRepo->criarOuAtualizar($parametrosInserir);

        $parametroMensagem = [
            "mensagem" => "Criado com sucesso",
            "classe" => "alert-success",
            "display" => "block"
        ];
    
        SessaoController::mensagemSessao($request, $parametroMensagem);
        return redirect()->route('controle_receita');
    }
}
