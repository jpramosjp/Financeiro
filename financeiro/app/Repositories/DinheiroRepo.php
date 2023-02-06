<?php

namespace App\Repositories;

use App\Models\Dinheiro;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DinheiroRepo
{

    public static function dinheiroUsuario($usuario) {
       return Dinheiro::where('usuario', $usuario)->get();
    }

   

    public static function criarOuAtualizar($params) {
        return Dinheiro::updateOrCreate([
            "codigo" => isset($params['codigo']) ? $params['codigo'] : '0',
            "usuario" => $params['usuario']
        ],
        [
            "usuario" => $params['usuario'],
            "valor" => $params['valor']
        ]);
    }
}