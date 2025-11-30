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
        Schema::create('tipo_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('capacidad_max_kg', 10, 2)->nullable();
            $table->decimal('capacidad_max_m3', 10, 2)->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Add tipo_vehiculo_id to vehiculos table
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->foreignId('tipo_vehiculo_id')->nullable()->after('id')->constrained('tipo_vehiculos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropForeign(['tipo_vehiculo_id']);
            $table->dropColumn('tipo_vehiculo_id');
        });
        
        Schema::dropIfExists('tipo_vehiculos');
    }
};
