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
                coalesce(B.descricao, A.descricao) as tipo_receita,
                coalesce(B.codigo, 0) as codigo_tipo_receita,
                (SELECT count(0) FROM receitas x WHERE x.tipo_receita = B.codigo) as quantidade_receita
            FROM 
                receitas A
            LEFT JOIN
                tipo_receita B
            ON
                B.codigo  = A.tipo_receita 
            WHERE 
                A.usuario = $usuario
            ORDER BY 
                A.codigo 
            "));
    }

    public static function tiposReceitas() {
        return DB::connection('pgsql')
            ->select(DB::raw("
            SELECT
                A.codigo as codigo,
                A.descricao as nome
            FROM 
                tipo_receita A
            "));
    }
}