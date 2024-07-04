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
        Schema::table('recibo_pagos', function (Blueprint $table) {

            $table->string('banco')->nullable()->after('medio')->comment('Banco donde se consigno el dinero');
            $table->date('fecha_transaccion')->nullable()->after('medio')->comment('Fecha en que se genero el pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recibo_pagos', function (Blueprint $table) {

            $table->dropColumn('banco');
            $table->dropColumn('fecha_transaccion');
        });
    }
};
