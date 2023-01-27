<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DespesaRepo
{

    public static function receitasUsuario($usuario) {
        return DB::connection('pgsql')
            ->select(DB::raw("
            SELECT
                A.codigo,
                A.valor,
                B.descricao as tipo_receita,
                (SELECT count(0) FROM despesa x WHERE x.tipo_despesa = B.codigo) as quantidade_receita
            FROM 
                despesa A
            INNER JOIN
                tipo_despesa B
            ON
                B.codigo  = A.tipo_despesa  
            WHERE 
                A.usuario = 30
            ORDER BY 
                A.codigo
            "));
    }
}