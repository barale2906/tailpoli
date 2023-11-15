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
        Schema::create('horarios', function (Blueprint $table) {
            $table->comment('Horarios aplicables a las sedes / cursos');
            $table->id();

            $table->unsignedBigInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes');

            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas');

            $table->unsignedBigInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('grupos');

            $table->boolean('tipo')->default(true)->comment('true horario de sede, false horario curso');
            $table->boolean('periodo')->default(true)->comment('true inicia, false termina, aplica para el horario de las sedes');

            $table->time('lunes')->comment('clases del lunes para esta sede, area y grupo');
            $table->time('martes')->comment('clases del martes para esta sede, area y grupo');
            $table->time('miercoles')->comment('clases del miercoles para esta sede, area y grupo');
            $table->time('jueves')->comment('clases del jueves para esta sede, area y grupo');
            $table->time('viernes')->comment('clases del viernes para esta sede, area y grupo');
            $table->time('sabado')->comment('clases del sabado para esta sede, area y grupo');
            $table->time('domingo')->comment('clases del domingo para esta sede, area y grupo');


            $table->boolean('status')->default(true)->comment('false Inactivo, true activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
