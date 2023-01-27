<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class SistemaController extends Controller
{
    public function index(Request $request) {
        $usuario = $request->session()->get('usuario');
        if(empty($usuario)) {
            return redirect()->route("login");
        }
        $menu = Menu::query()
        ->orderBy('codigo')
        ->get();
        $nomeAcesso = $usuario->nome;
        $imagemUsuario = !empty($usuario->imagem_usuario) ?" <img src='" . $usuario->imagem_usuario . "' alt='' width='32' height='32' class='rounded-circle me-2'>" : '<i class="fa-solid fa-user me-2"></i>';
        return view("sistema.index", compact("nomeAcesso", "imagemUsuario", "menu"));
    }
}
