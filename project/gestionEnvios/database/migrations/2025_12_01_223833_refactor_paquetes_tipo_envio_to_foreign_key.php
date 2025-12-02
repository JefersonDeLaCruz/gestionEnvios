<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add new foreign key column (nullable initially)
        Schema::table('paquetes', function (Blueprint $table) {
            $table->foreignId('tipo_envio_id')->nullable()->after('dimensiones')->constrained('tipos_envio')->onDelete('restrict');
        });

        // Step 2: Migrate existing data
        DB::statement("
            UPDATE paquetes p
            INNER JOIN tipos_envio te ON p.tipo_envio = te.nombre
            SET p.tipo_envio_id = te.id
        ");

        // Step 3: Make foreign key required and drop old column
        Schema::table('paquetes', function (Blueprint $table) {
            $table->foreignId('tipo_envio_id')->nullable(false)->change();
            $table->dropColumn('tipo_envio');
        });
    }

    public function down(): void
    {
        // Reverse the migration
        Schema::table('paquetes', function (Blueprint $table) {
            $table->enum('tipo_envio', ['estandar', 'express', 'overnight', 'premium'])->nullable()->after('dimensiones');
        });

        // Restore data
        DB::statement("
            UPDATE paquetes p
            INNER JOIN tipos_envio te ON p.tipo_envio_id = te.id
            SET p.tipo_envio = te.nombre
        ");

        // Drop foreign key
        Schema::table('paquetes', function (Blueprint $table) {
            $table->dropForeign(['tipo_envio_id']);
            $table->dropColumn('tipo_envio_id');
        });
    }
};
