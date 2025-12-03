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
        Schema::table('tipos_envio', function (Blueprint $table) {
            $table->decimal('tarifa_base', 10, 2)->default(0)->after('prioridad');
            $table->decimal('tarifa_por_kg', 10, 2)->default(0)->after('tarifa_base');
            $table->decimal('tarifa_por_m3', 10, 2)->default(0)->after('tarifa_por_kg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipos_envio', function (Blueprint $table) {
            $table->dropColumn(['tarifa_base', 'tarifa_por_kg', 'tarifa_por_m3']);
        });
    }
};
