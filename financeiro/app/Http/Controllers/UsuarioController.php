<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index (Request $request) {
        $mensagem = $request->session()->get('mensagem');
        return view('index', compact('mensagem'));
    }

    public function cadastro() {
        return view('cadastro');
    }

    public function criarUsuario(Request $request) {
        $request->merge(['senha_usuario' => Hash::make($request->input('senha_usuario'))]);
        $params = [
            "nome" => $request->input('nome_completo'),
            "nome_acesso" => $request->input('nome_usuario'),
            "senha" => $request->input('senha_usuario'),
            "imagem_usuario" => '',
            "data_nascimento" => $request->input('data_nascimento_usuario')
        ];
        $mensagem ="Usuario já cadastrado no sistema";
        if(!User::where('nome_acesso', $params['nome_acesso'])->exists()) {
            User::create($params);
            $mensagem = "Usuario criado com sucecsso";
        }


         $request->session()
         ->flash(
             "mensagem",
             $mensagem
         );
        return redirect()->route("login");
    }
}
