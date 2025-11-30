<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('envios', function (Blueprint $table) {
            // Make vehiculo_id and motorista_id nullable
            // This allows creating shipments without assigned driver/vehicle
            $table->foreignId('vehiculo_id')->nullable()->change();
            $table->foreignId('motorista_id')->nullable()->change();

            // Make costo nullable as well since it might be calculated later
            $table->decimal('costo', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('envios', function (Blueprint $table) {
            $table->foreignId('vehiculo_id')->nullable(false)->change();
            $table->foreignId('motorista_id')->nullable(false)->change();
            $table->decimal('costo', 10, 2)->nullable(false)->change();
        });
    }
};
