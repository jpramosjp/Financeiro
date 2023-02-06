<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    protected $connection = 'pgsql';
    protected $primaryKey = 'codigo';
    protected $table = 'despesa';
    protected $fillable = [
        'usuario',
        'valor',
        'tipo_despesa',
        'nome_despesa',
        'data_vencimento',
        'data_inserido'
    ];

    public $timestamps = false;
}
