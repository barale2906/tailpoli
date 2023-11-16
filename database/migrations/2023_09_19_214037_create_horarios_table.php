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

            $table->integer('grupo_id')->nullable()->comment('grupo al que aplica este horario');
            $table->string('grupo')->nullable()->comment('nombre del grupo asignado');

            $table->boolean('tipo')->default(true)->comment('true horario de sede, false horario curso');
            $table->boolean('periodo')->default(true)->comment('true inicia, false termina, aplica para el horario de las sedes');

            $table->string('dia')->comment('dia de la semana que se registra');

            $table->time('hora')->nullable()->comment('hora de inicio o cierre del horario');

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
