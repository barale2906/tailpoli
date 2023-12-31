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

            $table->string('medio')->comment('medio de pago');
            $table->string('producto')->nullable()->comment('producto facturado');
            $table->double('cantidad')->nullable()->comment('cantidad vendida');
            $table->double('unitario')->nullable()->comment('valor unitario');
            $table->double('subtotal')->nullable()->comment('subtotal del item');
            $table->string('id_relacional')->nullable()->comment('muestra el id del movimiento afectado ');

            $table->unsignedBigInteger('concepto_pago_id');
            $table->foreign('concepto_pago_id')->references('id')->on('concepto_pagos');

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
