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
        Schema::create('carteras', function (Blueprint $table) {
            $table->comment('Registro de deuda de los estudiantes');
            $table->id();
            $table->time('fecha_pago')->comment('Fecha de pago pactada');
            $table->time('fecha_real')->nullable()->comment('Fecha de pago real');
            $table->double('valor')->comment('Valor del concepto');
            $table->double('saldo')->default(0)->comment('Saldo del concepto');
            $table->longtext('observaciones')->comment('Historia de cambios');

            $table->unsignedBigInteger('matricula_id');
            $table->foreign('matricula_id')->references('id')->on('matriculas');

            $table->unsignedBigInteger('concepto_pago_id');
            $table->foreign('concepto_pago_id')->references('id')->on('concepto_pagos');

            $table->unsignedBigInteger('estado_cartera_id');
            $table->foreign('estado_cartera_id')->references('id')->on('estado_carteras');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carteras');
    }
};
