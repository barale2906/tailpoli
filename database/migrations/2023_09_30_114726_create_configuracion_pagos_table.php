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
            $table->comment('Describe todas las configuraciones de pago');
            $table->id();
            $table->double('valor_curso')->comment('Valor del curso para esta ubicación');
            $table->double('valor_matricula')->comment('Valor de la matricula');
            $table->double('valor_cuota_inicial')->comment('Valor cuota inicial');
            $table->integer('cuotas')->comment('numero de cuotas');
            $table->double('valor_cuota')->comment('Valor por cuota');
            $table->longText('descripcion');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');

            $table->unsignedBigInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes');

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
