<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Menucontroller;
use App\Repositories\ReceitasRepo;

class Receitascontroller extends Controller
{
    public function index(Request $request) {
        $receitasRepo = new ReceitasRepo;
        $menu = Menucontroller::montarMenu($request);
        $usuario = Menucontroller::dadosUsuario($request);
        $nomePagina = "Controle de Receita";
        $listaReceitas = $receitasRepo->tiposReceitas();
        $todasReceitas = $receitasRepo->receitasUsuario($usuario->codigo);
        return view('sistema.receitas', compact("nomePagina", "usuario", "menu", "listaReceitas", "todasReceitas"));
    }

    public function atualizarReceitas($data) {
        return response()->json(array('msg'=> "opa"), 200);
    }
}
