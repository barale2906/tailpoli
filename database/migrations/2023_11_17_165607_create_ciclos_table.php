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
        Schema::create('ciclos', function (Blueprint $table) {
            $table->comment('Crea ciclos de cursos');
            $table->id();

            $table->string('name')->comment('nombre del ciclo');
            $table->date('inicia')->comment('Fecha inicio del ciclo');
            $table->date('finaliza')->comment('Fecha final del ciclo');
            $table->integer('registrados')->default(0)->comment('Cantidad de registrados al ciclo');
            $table->integer('jornada')->comment('Jornada 1 Mañana, 2 Tarde, 3 Noche, 4 Fin de semana');
            $table->integer('desertado')->comment('numero de días para determinar si es desertado o no el estudiante según el tipo');
            $table->boolean('status')->default(true)->comment('false inactiva, true activa');

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
        Schema::dropIfExists('ciclos');
    }
};
