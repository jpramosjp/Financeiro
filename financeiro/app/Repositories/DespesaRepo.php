<?php

namespace App\Repositories;

use App\Models\Despesa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DespesaRepo
{

    public static function despesaUsuario($usuario, $periodo) {
        return DB::connection('pgsql')
            ->select(DB::raw("
            SELECT
                A.codigo,
                A.valor,
                B.descricao as tipo_despesa,
                (SELECT count(0) FROM despesa x WHERE x.tipo_despesa = B.codigo AND x.data_vencimento BETWEEN $periodo ) as quantidade_despesa,
                B.cor,
                B.codigo as codigo_despesa,
                A.nome_despesa,
                A.data_vencimento
            FROM 
                despesa A
            INNER JOIN
                tipo_despesa B
            ON
                B.codigo  = A.tipo_despesa  
            WHERE 
                A.usuario = $usuario
                AND A.data_vencimento BETWEEN $periodo
            ORDER BY 
                A.codigo
            "));
    }

    public static function tipoDespesaUsuario($usuario) {
        return DB::connection('pgsql')
        ->select(DB::raw("
        SELECT DISTINCT
            tipo_despesa as codigo,
            B.descricao as nome,
            B.cor 
        FROM 
            despesa A
        INNER JOIN
            tipo_despesa B
        ON
            B.codigo  = A.tipo_despesa
        WHERE
            A.usuario = $usuario 
        "));
    }

    public static function cadaDespesaUuario($usuario, $tiposDespesas, $periodo) {
        return DB::connection('pgsql')
        ->select(DB::raw("
                SELECT
                    A.nome_despesa,
                    A.valor,
                    to_char( A.data_vencimento, 'DD/MM/YYYY') as data_vencimento,
                    B.descricao as nome_tipo_despesa
                FROM 
                    despesa A
                INNER JOIN
                    tipo_despesa B
                ON
                    B.codigo  = A.tipo_despesa
                WHERE 
                    A.tipo_despesa IN ($tiposDespesas)
                    AND A.usuario = $usuario
                    AND A.data_vencimento BETWEEN $periodo
        "));
    }

    public static function tipoDespesa() {
        return DB::connection('pgsql')
        ->select(DB::raw("
                SELECT
                   A.codigo,
                   A.descricao as nome
                FROM 
                    tipo_despesa A
                ORDER BY A.codigo ASC
        "));
    }

    public static function criarOuAtualizar($params) {
        return Despesa::updateOrCreate([
            "codigo" => isset($params['codigo']) ? $params['codigo'] : '0',
            "usuario" => $params['usuario']
        ],
        [
            "usuario" => $params['usuario'],
            "tipo_despesa" => $params['tipo_despesa'],
            "nome_despesa" => $params['nome_despesa'],
            "valor" => $params['valor'],
            "data_vencimento" => $params['data_vencimento'],
            "data_inserido" => \Carbon\Carbon::now()->format('Y-m-d')
        ]);
    }
}