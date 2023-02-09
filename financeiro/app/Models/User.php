<?php
namespace App\Models;

use  Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'pgsql';
    protected $primaryKey = 'codigo';
    protected $table = 'usuarios';
    protected $fillable = [
        'nome',
        'nome_acesso',
        'senha',
        'imagem_usuario',
        'data_nascimento'
    ];
    
    public $timestamps = false;
}