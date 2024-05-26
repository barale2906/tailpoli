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
        Schema::table('transaccions', function (Blueprint $table) {
            $table->date('fecha_transaccion')->after('academico')->comment('Fecha en que se realizo el pago por parte del estudiante');
            $table->double('total')->after('fecha_transaccion')->comment('Total de la consignación');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaccions', function (Blueprint $table) {
            $table->dropColumn('fecha_transaccion');
            $table->dropColumn('total');
        });
    }
};
