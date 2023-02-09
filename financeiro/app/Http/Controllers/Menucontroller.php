<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class Menucontroller extends Controller
{
    public static function montarMenu(Request $request) {
        return Menu::query()
        ->orderBy('codigo')
        ->get();
    }

    public static function dadosUsuario(Request $request) {
        $usuario = $request->session()->get('usuario');
        $usuario->imagem_usuario = (!empty($usuario->imagem_usuario) && strpos($usuario->imagem_usuario, "<i class") === false) ?" <img src='" . $usuario->imagem_usuario . "' alt='' width='32' height='32' class='rounded-circle me-2'>" : '<i class="fa-solid fa-user me-2"></i>';
        return $usuario;
    }
}
