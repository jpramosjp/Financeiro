<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $connection = 'pgsql';
    protected $primaryKey = 'codigo';
    protected $table = 'menu';
    protected $fillable = [
        'nome',
        'classe'
    ];
    
    public $timestamps = false;
}
