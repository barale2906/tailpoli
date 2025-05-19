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
        Schema::table('ciclos', function (Blueprint $table) {
            $table->integer('creado')->nullable()->after('desertado')->comment('ID del usuario que creo el ciclo');
            $table->longText('observaciones')->nullable()->after('creado')->comment('comentarios al ciclo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ciclos', function (Blueprint $table) {
            $table->dropColumn('creado');
            $table->dropColumn('observaciones');
        });
    }
};
