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

            $table->unsignedBigInteger('concepto_pago_id');
            $table->foreign('concepto_pago_id')->references('id')->on('concepto_pagos');

            $table->unsignedBigInteger('cartera_id');
            $table->foreign('cartera_id')->references('id')->on('carteras');

            $table->unsignedBigInteger('recibo_pago_id');
            $table->foreign('recibo_pago_id')->references('id')->on('recibo_pagos');

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
