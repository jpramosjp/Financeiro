<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receitas extends Model
{
    protected $connection = 'pgsql';
    protected $primaryKey = 'codigo';
    protected $table = 'receitas';
    protected $fillable = [
        'usuario',
        'valor',
        'tipo_receita',
        'data_inserido',
        'descricao'
    ];
    
    public $timestamps = false;
}
