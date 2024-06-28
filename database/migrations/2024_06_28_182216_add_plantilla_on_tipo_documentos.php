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
        Schema::table('tipo_documentos', function (Blueprint $table) {

            $table->integer('plantilla')->default(1)->after('descripcion')->comment('1 encabezado y pie de página, 2 Encabezado, 3 Sin formato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipo_documentos', function (Blueprint $table) {

            $table->dropColumn('plantilla');
        });
    }
};
