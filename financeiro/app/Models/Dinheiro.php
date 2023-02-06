<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dinheiro extends Model
{
    protected $connection = 'pgsql';
    protected $primaryKey = 'codigo';
    protected $table = 'dinheiro_guardado';
    protected $fillable = [
        'usuario',
        'valor'
    ];

    public $timestamps = false;
}
