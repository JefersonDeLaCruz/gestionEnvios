<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class envio_cliente extends Model
{
    /** @use HasFactory<\Database\Factories\EnvioClienteFactory> */
    use HasFactory;
    protected $table = 'envio_clientes';
    protected $fillable = [
        'cliente_id',
        'paquete_id',
        'tipo_cliente',
    ];
    public function cliente()
    {
        return $this->belongsTo(cliente::class);
    }
    public function paquete()
    {
        return $this->belongsTo(paquete::class);
    }
}
