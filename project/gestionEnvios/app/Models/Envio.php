<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    /** @use HasFactory<\Database\Factories\EnvioFactory> */
    use HasFactory;
    protected $table = 'envios';
    protected $fillable = [
        'paquete_id',
        'vehiculo_id',
        'motorista_id',
        'estado_envio_id',
        'fecha_estimada',
        'costo',
    ];
    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
    public function estadoEnvio()
    {
        return $this->belongsTo(EstadoEnvio::class);
    }
    public function historialEnvios()
    {
        return $this->hasMany(HistorialEnvio::class);
    }
    public function motorista()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get pending shipments (no assigned driver)
     */
    public function scopePendientes($query)
    {
        return $query->whereNull('motorista_id')
            ->whereNull('vehiculo_id');
    }
}
