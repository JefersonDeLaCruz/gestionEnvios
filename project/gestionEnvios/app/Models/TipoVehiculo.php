<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVehiculo extends Model
{
    use HasFactory;
    
    protected $table = 'tipo_vehiculos';
    
    protected $fillable = [
        'nombre',
        'capacidad_max_kg',
        'capacidad_max_m3',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'capacidad_max_kg' => 'decimal:2',
        'capacidad_max_m3' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }
}
