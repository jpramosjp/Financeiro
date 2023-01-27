<?php

namespace App\Repositories;

use App\Models\Receitas;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReceitasRepo
{

    public static function receitasUsuario($usuario) {
        return DB::connection('pgsql')
            ->select(DB::raw("
            SELECT
                A.codigo,
                A.valor,
                B.descricao as tipo_receita,
                (SELECT count(0) FROM receitas x WHERE x.tipo_receita = B.codigo) as quantidade_receita
            FROM 
                receitas A
            INNER JOIN
                tipo_receita B
            ON
                B.codigo  = A.tipo_receita 
            WHERE 
                A.usuario = $usuario
            ORDER BY 
                A.codigo 
            "));
    }
}