<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    /** @use HasFactory<\Database\Factories\VehiculoFactory> */
    use HasFactory;
    protected $table = 'vehiculos';
    protected $fillable = [
        'tipo_vehiculo_id',
        'numero_placas',
        'marca',
        'modelo',
        'capacidad_kg',
        'capacidad_m3',
        'disponible',
    ];

    public function tipoVehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class);
    }

    /**
     * Get the drivers (motoristas) assigned to this vehicle
     */
    public function motoristas()
    {
        return $this->belongsToMany(User::class, 'motorista_vehiculo', 'vehiculo_id', 'motorista_id')
            ->withPivot('activo')
            ->withTimestamps();
    }
}
