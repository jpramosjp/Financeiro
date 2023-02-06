<?php

namespace App\Repositories;

use App\Models\Meses;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class MesesRepo
{
    public static function buscaPeriodoMes($data) {
        try {
            return DB::connection('pgsql')
            ->select(DB::raw("
            SELECT 
                * 
            FROM 
                meses m 
            WHERE 
                date_trunc('month', $data::date) BETWEEN inicio  AND fim ;
            "));
        }
        catch(Exception $e) {
            return false;
        }
    }
}