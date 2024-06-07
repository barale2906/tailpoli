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
        Schema::create('asistencia_detalle_registro', function (Blueprint $table) {
            $table->comment('Se registra las fechas en que asiste el estudiante');
            $table->id();

            $table->unsignedBigInteger('asistencia_detalle_id');
            $table->foreign('asistencia_detalle_id')->references('id')->on('asistencia_detalle');

            $table->date('fecha_asis')->comment('Fecha de asistencia según el registro de asistencia');
            $table->integer('registro_asistencia_id')->comment('Corresponde al registro de asistencia al cuál asistio');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_detalle_registro');
    }
};
