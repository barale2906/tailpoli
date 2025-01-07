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
        Schema::create('cronodetas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cronograma_id');
            $table->foreign('cronograma_id')->references('id')->on('cronogramas');

            $table->unsignedBigInteger('unidtema_id');
            $table->foreign('unidtema_id')->references('id')->on('unidtemas');

            $table->date('fecha_programada')->comment('FEcha en que se debe ejecutar la tarea');
            $table->double('duracion')->comment('Duración de la en horas');
            $table->integer('usuario')->comment('Usuario que genera el registro');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cronodetas');
    }
};
