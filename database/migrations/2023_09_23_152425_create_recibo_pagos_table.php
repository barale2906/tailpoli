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
        Schema::create('recibo_pagos', function (Blueprint $table) {
            $table->comment('Detalles de los recibos de pago');
            $table->id();
            $table->integer('numero_recibo')->comment('número del recibo de caja');
            $table->boolean('origen')->default(true)->comment('false externo - dotaciones-otros, true interno - propio del instituto');
            $table->date('fecha')->comment('Fecha del recibo');
            $table->double('valor_total')->comment('Valor total del recibo');
            $table->string('medio')->comment('medio de pago');
            $table->longtext('observaciones')->comment('Obserevaciones al recibo');
            $table->integer('status')->default(0)->comment('0 Creado, 1 cerrado, 2 anulado');
            $table->integer('cierre')->nullable()->comment('#Cierre de caja');

            $table->unsignedBigInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes');

            $table->unsignedBigInteger('creador_id');
            $table->foreign('creador_id')->references('id')->on('users');

            $table->unsignedBigInteger('paga_id');
            $table->foreign('paga_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibo_pagos');
    }
};
