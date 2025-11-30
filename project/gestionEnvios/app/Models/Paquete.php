<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    /** @use HasFactory<\Database\Factories\PaqueteFactory> */
    use HasFactory;
    protected $table = 'paquetes';
    protected $fillable = [
        'codigo',
        'descripcion',
        'peso',
        'dimensiones',
        'tipo_envio',
    ];
    public function envios()
    {
        return $this->hasMany(Envio::class);
    }

    public function envioClientes()
    {
        return $this->hasMany(EnvioCliente::class);
    }
}
