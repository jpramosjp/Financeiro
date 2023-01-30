<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meses extends Model
{
    protected $connection = 'pgsql';
    protected $primaryKey = 'codigo';
    protected $table = 'meses';
    protected $fillable = [
        'nome',
        'inicio',
        'fim'
    ];
    
    public $timestamps = false;
}
