<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SessaoController;


use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index (Request $request) {
        $mensagem = !empty($request->session()->get('mensagem')) ? $request->session()->get('mensagem') : '';
        $classe = !empty($request->session()->get("classe")) ? $request->session()->get("classe") : '';
        $display = !empty($request->session()->get('display')) ? $request->session()->get("display") : 'none';
        return view('index', compact("mensagem", "classe", "display"));
    }

    public function logar(Request $request) {
        if(empty($request->input('nome_acesso')) || empty($request->input('senha'))) {
            SessaoController::mensagemSessao($request, ["mensagem" => "Por favor preencha todos os campos", "classe" => "alert-danger", "display" => "block"]);
            return redirect()->route("login");
        }
        $usuario = User::where('nome_acesso', $request->input('nome_acesso'))->first();
        if(empty($usuario) || !Hash::check($request->input('senha'), $usuario->senha)) {
            SessaoController::mensagemSessao($request, ["mensagem" => "Usuario ou senha inválido", "classe" => "alert-danger", "display" => "block"]);
            return redirect()->route("login");
        }
        SessaoController::criarSessaoUsuario($request, ["usuario" => $usuario, "data_entrada" => \Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        return redirect()->route('sistema');
        
    }

    public function cadastro(Request $request) {
        $mensagem = !empty($request->session()->get('mensagem')) ? $request->session()->get('mensagem') : '';
        $classe = !empty($request->session()->get("classe")) ? $request->session()->get("classe") : '';
        $display = !empty($request->session()->get('display')) ? $request->session()->get("display") : 'none';
        return view('cadastro', compact("mensagem", "classe", "display"));
    }

    public function criarUsuario(Request $request) {
        if(empty($request->input('nome_completo')) || empty($request->input('nome_usuario')) || empty($request->input('senha_usuario')) || empty($request->input('data_nascimento_usuario'))) {
            SessaoController::mensagemSessao($request, ["mensagem" => "Por favor preencha todos os campos", "classe" => "alert-danger", "display" => "block"]);
            return redirect()->route("form_cadastro_usuario");
        }
        $request->merge(['senha_usuario' => Hash::make($request->input('senha_usuario'))]);
        $params = [
            "nome" => $request->input('nome_completo'),
            "nome_acesso" => $request->input('nome_usuario'),
            "senha" => $request->input('senha_usuario'),
            "imagem_usuario" => '',
            "data_nascimento" => $request->input('data_nascimento_usuario')
        ];
        $mensagem = "Usuario já cadastrado no sistema";
        $classe = "alert-danger";
        $display = "block";
        if(!User::where('nome_acesso', $params['nome_acesso'])->exists()) {
            User::create($params);
            $mensagem = "Usuario criado com sucecsso";
            $classe = "alert-success";
        }
        $parametroMensagem = [
            "mensagem" => $mensagem,
            "classe" => $classe,
            "display" => $display
        ];

        SessaoController::mensagemSessao($request, $parametroMensagem);
        
        return redirect()->route("login");
    }

}
