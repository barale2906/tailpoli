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
        Schema::create('acaplandetas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('acaplan_id');
            $table->foreign('acaplan_id')->references('id')->on('acaplans');

            $table->unsignedBigInteger('unidtema_id');
            $table->foreign('unidtema_id')->references('id')->on('unidtemas');

            $table->double('horas_teoricas')->comment('horas de teoria en la clase');
            $table->double('horas_practicas')->comment('horas de practica en la clase');
            $table->longText('actividades')->nullable()->comment('Describe actividades realizadas');
            $table->longText('evidencias')->nullable()->comment('Pruebas de ejecución');
            $table->longText('resultados')->nullable()->comment('Resultados obtenidos - Esperados para la actividad');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acaplandetas');
    }
};
