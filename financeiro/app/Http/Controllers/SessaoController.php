<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessaoController extends Controller
{
    /**
     * @param Request $request 
     * @param Array $parametros
     * @return Bool 
    */
    public static function mensagemSessao(Request $request, $parametros) {
        foreach($parametros as $indice => $valor) {
            $request->session()
                    ->flash(
                        $indice, $valor
                    );
        }
        return true;
    }

    public static function criarSessaoUsuario(Request $request, $parametros) {
        foreach($parametros as $indice => $valor) {
            $request->session()
                    ->put(
                        $indice, $valor
                    );
        }
    }

}
