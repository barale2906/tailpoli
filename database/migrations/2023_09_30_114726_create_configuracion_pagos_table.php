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
        Schema::create('configuracion_pagos', function (Blueprint $table) {
            $table->comment('Describe todas las configuraciones de pago (listas de precios)');
            $table->id();
            $table->date('inicia')->comment('Fecha inicio de la configuración');
            $table->date('finaliza')->comment('Fecha final de la configuración');
            $table->double('valor_curso')->comment('Valor del curso para esta ubicación');
            $table->double('valor_matricula')->comment('Valor de la matricula');
            //$table->double('valor_cuota_inicial')->comment('Valor cuota inicial');
            $table->integer('cuotas')->comment('numero de cuotas');
            $table->double('valor_cuota')->comment('Valor por cuota');
            $table->double('descuento')->nullable()->comment('descuento aplicable');
            $table->longText('descripcion');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');
            $table->boolean('incluye')->default(true)->comment('false incluye algunos modulos, true incluye todos los modulos');

            $table->unsignedBigInteger('sector_id');
            $table->foreign('sector_id')->references('id')->on('sectors');

            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('cursos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_pagos');
    }
};
