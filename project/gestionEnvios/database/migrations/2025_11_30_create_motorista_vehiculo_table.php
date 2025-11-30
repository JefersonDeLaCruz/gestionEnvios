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
        Schema::create('motorista_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorista_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vehiculo_id')->constrained()->cascadeOnDelete();
            $table->boolean('activo')->default(true); // Indicates if this assignment is currently active
            $table->timestamps();

            // A driver can only have one active vehicle at a time
            $table->unique(['motorista_id', 'activo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorista_vehiculo');
    }
};
