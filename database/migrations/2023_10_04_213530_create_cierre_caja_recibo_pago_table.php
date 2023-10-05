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
        Schema::create('cierre_caja_recibo_pago', function (Blueprint $table) {
            $table->comment('Recibos de caja adjuntos a los cierres de caja');
            $table->id();

            $table->unsignedBigInteger('cierre_caja_id');
            $table->foreign('cierre_caja_id')->references('id')->on('cierre_cajas');

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
        Schema::dropIfExists('cierre_caja_recibo_pago');
    }
};
