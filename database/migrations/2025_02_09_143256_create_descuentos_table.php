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
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('nombre del descuento');
            $table->integer('tipo')->comment('0 valor, 1 porcentaje');
            $table->double('valor')->comment('Valor del descuento a aplicar');
            $table->integer('aplica')->comment('0 fecha de pago, 1 fecha de inicio, ');
            $table->integer('status')->comment('0 inactivo 1 activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};
