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
    /**
     * Get the drivers (motoristas) assigned to this vehicle
     */
    public function motoristas()
    {
        return $this->belongsToMany(User::class, 'motorista_vehiculo', 'vehiculo_id', 'motorista_id')
            ->withPivot('activo')
            ->withTimestamps();
    }

    /**
     * Calculate the current load of the vehicle based on packages 'en-ruta'
     * @param int|null $excludeEnvioId
     */
    public function calculateCurrentLoad($excludeEnvioId = null)
    {
        return Envio::where('vehiculo_id', $this->id)
            ->whereHas('estadoEnvio', function ($q) {
                $q->where('slug', 'en-ruta');
            })
            ->when($excludeEnvioId, function ($q) use ($excludeEnvioId) {
                $q->where('id', '!=', $excludeEnvioId);
            })
            ->with('paquete')
            ->get()
            ->reduce(function ($carry, $envio) {
                return [
                    'peso' => $carry['peso'] + ($envio->paquete->peso ?? 0),
                    'volumen' => $carry['volumen'] + ($envio->paquete->dimensiones ?? 0),
                ];
            }, ['peso' => 0, 'volumen' => 0]);
    }

    /**
     * Check if the vehicle can accommodate a specific package
     * Returns true if it fits, or an error message string if it doesn't.
     * 
     * @param Paquete $paquete
     * @param int|null $excludeEnvioId Optional envio ID to exclude from current load (for updates)
     * @return bool|string
     */
    public function canAccommodate(Paquete $paquete, $excludeEnvioId = null)
    {
        $currentLoad = $this->calculateCurrentLoad($excludeEnvioId);

        // If we are updating an existing shipment that is ALREADY 'en-ruta', we should subtract it?
        // Actually, the calculateCurrentLoad gets ALL 'en-ruta'. 
        // If we are checking for a package that is NOT yet 'en-ruta', we just add it.
        // If we are checking for a package that IS 'en-ruta' (e.g. updating something else), it's already counted.
        // BUT, the use case is: changing status TO 'en-ruta'. 
        // If it was already 'en-ruta', we shouldn't be here (or it doesn't matter).
        // If it was 'pendiente', it's not in the count.

        // However, to be safe and reusable, if we pass an ID to exclude (the one we are editing), 
        // we should handle that in calculateCurrentLoad, but calculateCurrentLoad is simple.
        // Let's refine calculateCurrentLoad to accept exclusion or handle it here.
        // For simplicity, let's just re-query or filter if needed, but for now, 
        // the standard case is adding a NEW package to 'en-ruta'.

        // Wait, if I am editing an envio, and I want to check if it fits, 
        // if it is NOT currently 'en-ruta', it is not in $currentLoad.
        // If it IS currently 'en-ruta', it IS in $currentLoad.
        // But we only validate when switching TO 'en-ruta'.
        // So usually it is NOT 'en-ruta' yet.

        // Let's stick to the logic I wrote in the controller:
        // ->where('id', '!=', $this->selectedEnvio->id)
        // So I should allow passing an ID to exclude from the "current load" calculation 
        // just in case we are re-saving an 'en-ruta' package (though unlikely to check capacity then).

        // Actually, let's modify calculateCurrentLoad to accept an exclusion ID.

        $newTotalPeso = $currentLoad['peso'] + ($paquete->peso ?? 0);
        $newTotalVolumen = $currentLoad['volumen'] + ($paquete->dimensiones ?? 0);

        // Check Weight
        if ($newTotalPeso > $this->capacidad_kg) {
            return "Capacidad de peso excedida. (Actual: {$currentLoad['peso']}kg + Paquete: {$paquete->peso}kg > Max: {$this->capacidad_kg}kg)";
        }

        // Check Volume (m³)
        if ($newTotalVolumen > $this->capacidad_m3) {
            $currentM3 = number_format($currentLoad['volumen'], 4);
            $packageM3 = number_format($paquete->dimensiones, 4);
            return "Capacidad de volumen excedida. (Actual: {$currentM3}m³ + Paquete: {$packageM3}m³ > Max: {$this->capacidad_m3}m³)";
        }

        return true;
    }
}
