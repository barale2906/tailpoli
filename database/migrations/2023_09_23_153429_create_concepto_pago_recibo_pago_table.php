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
        Schema::create('concepto_pago_recibo_pago', function (Blueprint $table) {
            $table->comment('conceptos de pago por recibo de caja');
            $table->id();

            $table->double('valor')->comment('Valor pagado concepto pago');
            $table->string('tipo')->comment('otros, cartera, inventario');
            //$table->longtext('detalle')->comment('Detalle de la transacción');

            $table->unsignedBigInteger('conceptos_id');
            $table->foreign('conceptos_id')->references('id')->on('concepto_pagos');

            $table->unsignedBigInteger('recibo_id');
            $table->foreign('recibo_id')->references('id')->on('recibo_pagos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concepto_pago_recibo_pago');
    }
};
