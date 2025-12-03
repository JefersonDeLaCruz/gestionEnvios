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
        Schema::table('paquetes', function (Blueprint $table) {
            // Add descripcion field
            $table->text('descripcion')->nullable()->after('codigo');

            // Change dimensiones from decimal to string
            $table->string('dimensiones', 255)->nullable()->change();

            // Update tipo_envio enum values
            $table->dropColumn('tipo_envio');
        });

        Schema::table('paquetes', function (Blueprint $table) {
            $table->enum('tipo_envio', ['estandar', 'express', 'overnight'])->default('estandar')->after('dimensiones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear dimensiones data that can't be converted to decimal
        \Illuminate\Support\Facades\DB::table('paquetes')
            ->update(['dimensiones' => null]);

        Schema::table('paquetes', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->decimal('dimensiones', 8, 2)->change();
            $table->dropColumn('tipo_envio');
        });

        Schema::table('paquetes', function (Blueprint $table) {
            $table->enum('tipo_envio', ['rapido', 'normal'])->after('dimensiones');
        });
    }
};
