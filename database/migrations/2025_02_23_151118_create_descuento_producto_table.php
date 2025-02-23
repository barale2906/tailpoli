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
        Schema::create('descuento_producto', function (Blueprint $table) {
            $table->id();

            $table->integer('descuento_id')->comment('Descuento al que pertenece');
            $table->integer('concepto_pago_id')->comment('Concepto pago aplicado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuento_producto');
    }
};
