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
        Schema::table('documentos', function (Blueprint $table) {

            $table->integer('control')->default(0)->after('tipo')->comment('0 libre impresión, 1 Controlado, 2 Graduaciones');
            $table->integer('tipo_curso')->default(3)->after('control')->comment('1 Práctico, 2 Técnico, 3 Indiferente');
            $table->integer('orientacion')->default(1)->after('tipo_curso')->comment('1 Vertical, 2 Horizontal');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {

            $table->dropColumn('control');
            $table->dropColumn('tipo_curso');
            $table->dropColumn('orientacion');
        });
    }
};
