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
        Schema::create('pago_configs_producto', function (Blueprint $table) {
            $table->comment('relacion de productos y precio por configuración');
            $table->id();

            $table->double('valor')->comment('Valor por unidad');

            $table->unsignedBigInteger('pago_configs_id');
            $table->foreign('pago_configs_id')->references('id')->on('pago_configs');

            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_configs_producto');
    }
};
