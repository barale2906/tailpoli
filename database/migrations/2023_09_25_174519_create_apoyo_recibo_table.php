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
        Schema::create('apoyo_recibo', function (Blueprint $table) {
            $table->comment('Registro de articulos temporales para recibo pago o carga de inventarios');
            $table->id();
            $table->string('tipo')->comment('otros, inventario o cartera');
            $table->integer('id_creador')->comment('Usuario que genera el recibo');
            $table->integer('id_concepto')->nullable()->comment('id concepto de pago, aplica solo para recibos de pago');
            $table->string('concepto')->nullable()->comment('nombre del concepto del recibo');

            $table->double('valor')->comment('valor-precio registrado en el recibo o en el inventario');
            $table->double('cantidad')->nullable()->comment('cuantas ingresan o salen del inventario');
            $table->double('subtotal')->nullable()->comment('Total del registro');
            $table->boolean('entregado')->default(true)->comment('true entregado false pendiente');

            $table->date('fecha_movimiento')->nullable()->comment('fecha en que se registra el movimiento');
            $table->date('fecha_fin')->nullable()->comment('fecha final modulos');


            $table->integer('id_producto')->nullable()->comment('id del prducto registrado');
            $table->string('producto')->nullable()->comment('nombre del producto');
            $table->integer('id_almacen')->nullable()->comment('id del almacén de donde se hizo el movimiento');
            $table->string('almacen')->nullable()->comment('nombre del almacén del movimiento');
            $table->integer('id_ultimoreg')->nullable()->comment('id del último registro activo');

            $table->double('saldo')->nullable()->comment('Saldo del concepto o del producto al momento del registro');
            $table->integer('id_cartera')->nullable()->comment('id del registro de cartera');

            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo cambia a false cuando no se pueda gestionar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apoyo_recibo');
    }
};
