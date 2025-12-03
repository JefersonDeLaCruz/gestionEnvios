<?php

use App\Models\Vehiculo;
use App\Models\Paquete;
use App\Models\Envio;
use App\Models\EstadoEnvio;
use App\Models\User;

// Setup
$vehiculo = Vehiculo::first();
// Set low capacity for testing
$originalCapKg = $vehiculo->capacidad_kg;
$originalCapM3 = $vehiculo->capacidad_m3;
$vehiculo->update(['capacidad_kg' => 10, 'capacidad_m3' => 1]);

echo "Vehicle Capacity: {$vehiculo->capacidad_kg}kg, {$vehiculo->capacidad_m3}m3\n";

// Create a package that fits
$pkgFits = Paquete::factory()->create(['peso' => 5, 'dimensiones' => 1000]); // 1000cm3 = 0.001m3
echo "Package 1: {$pkgFits->peso}kg\n";

// Check if it fits
$result = $vehiculo->canAccommodate($pkgFits);
echo "Can accommodate Package 1? " . ($result === true ? "YES" : "NO: $result") . "\n";

// Create a package that exceeds weight
$pkgHeavy = Paquete::factory()->create(['peso' => 15, 'dimensiones' => 1000]);
echo "Package 2: {$pkgHeavy->peso}kg\n";

$result = $vehiculo->canAccommodate($pkgHeavy);
echo "Can accommodate Package 2? " . ($result === true ? "YES" : "NO: $result") . "\n";

// Restore
$vehiculo->update(['capacidad_kg' => $originalCapKg, 'capacidad_m3' => $originalCapM3]);
echo "Restored Vehicle Capacity.\n";
