<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paquete extends Model
{
    /** @use HasFactory<\Database\Factories\PaqueteFactory> */
    use HasFactory;
    protected $table = 'paquetes';
    protected $fillable = [
        'codigo',
        'peso',
        'dimensiones',
        'tipo_envio',
    ];
}
