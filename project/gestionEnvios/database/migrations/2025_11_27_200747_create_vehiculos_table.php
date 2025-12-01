<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_vehiculo_id')->nullable()->constrained('tipo_vehiculos')->nullOnDelete();
   
            $table->string('numero_placas')->unique();
            $table->string('marca');
            $table->string('modelo');
            $table->decimal('capacidad_kg', 10, 2);
            $table->decimal('capacidad_m3', 10, 2);
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
