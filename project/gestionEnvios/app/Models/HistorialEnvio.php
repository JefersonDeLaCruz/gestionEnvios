<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialEnvio extends Model
{
    /** @use HasFactory<\Database\Factories\HistorialEnvioFactory> */
    use HasFactory;
    protected $table = 'historial_envios';
    protected $fillable = [
        'envio_id',
        'estado_envio_id',
        'comentario',
        'foto_url',
    ];
    public function envio()
    {
        return $this->belongsTo(Envio::class);
    }
    public function estadoEnvio()
    {
        return $this->belongsTo(EstadoEnvio::class);
    }
}
