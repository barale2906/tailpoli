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
        Schema::create('pago_configs', function (Blueprint $table) {
            $table->comment('Describe todas las configuraciones de pago para productos de inventario (listas de precios)');
            $table->id();
            $table->date('inicia')->comment('Fecha inicio de la configuración');
            $table->date('finaliza')->comment('Fecha final de la configuración');
            $table->longText('descripcion');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');

            $table->unsignedBigInteger('sector_id');
            $table->foreign('sector_id')->references('id')->on('sectors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_configs');
    }
};
