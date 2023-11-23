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
        Schema::create('ciclogrupos', function (Blueprint $table) {
            $table->comment('Crea ciclos de cursos');
            $table->id();

            $table->unsignedBigInteger('ciclo_id');
            $table->foreign('ciclo_id')->references('id')->on('ciclos');

            $table->unsignedBigInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('grupos');

            $table->date('fecha_inicio')->comment('Fecha inicio del modulo dentro del ciclo');
            //$table->integer('inscritos')->default(0)->comment('Cantidad de alumnos inscritos a este grupo - ciclo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclogrupos');
    }
};
