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
        Schema::create('concepto_pagos', function (Blueprint $table) {
            $table->comment('Descripción de los conceptos de pago generados');
            $table->id();
            $table->string('name')->comment('nombre del concepto de pago configurado');
            $table->string('tipo')->comment('que clase de concepto de pago es cartera, inventario, etc');
            $table->double('valor')->default(0)->comment('valor del concepto de pago cuando aplica');
            $table->boolean('status')->default(true)->comment('false Inactivo, true activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concepto_pagos');
    }
};
