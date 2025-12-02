<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEnvio extends Model
{
    protected $table = 'tipos_envio';

    protected $fillable = [
        'nombre',
        'prioridad',
        'tarifa_base',
        'tarifa_por_kg',
        'tarifa_por_m3',
    ];

    protected $casts = [
        'tarifa_base' => 'decimal:2',
        'tarifa_por_kg' => 'decimal:2',
        'tarifa_por_m3' => 'decimal:2',
    ];

    public function paquetes()
    {
        return $this->hasMany(Paquete::class, 'tipo_envio_id');
    }
}
