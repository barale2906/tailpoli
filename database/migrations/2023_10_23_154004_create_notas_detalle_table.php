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
        Schema::create('notas_detalle', function (Blueprint $table) {
            $table->comment('control de las notas generadas por cada estudiante en los grupos');
            $table->id();

            $table->unsignedBigInteger('nota_id');
            $table->foreign('nota_id')->references('id')->on('notas');

            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('users');
            $table->string('alumno');

            $table->unsignedBigInteger('profesor_id');
            $table->foreign('profesor_id')->references('id')->on('users');
            $table->string('profesor');

            $table->unsignedBigInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('grupos');
            $table->string('grupo');

            $table->double('nota1')->nullable()->comment('valor de la nota');
            $table->double('procen1')->nullable()->comment('porcentaje de la nota');

            $table->double('nota2')->nullable()->comment('valor de la nota');
            $table->double('procen2')->nullable()->comment('porcentaje de la nota');

            $table->double('nota3')->nullable()->comment('valor de la nota');
            $table->double('procen3')->nullable()->comment('porcentaje de la nota');

            $table->double('nota4')->nullable()->comment('valor de la nota');
            $table->double('procen4')->nullable()->comment('porcentaje de la nota');

            $table->double('nota5')->nullable()->comment('valor de la nota');
            $table->double('procen5')->nullable()->comment('porcentaje de la nota');

            $table->double('nota6')->nullable()->comment('valor de la nota');
            $table->double('procen6')->nullable()->comment('porcentaje de la nota');

            $table->double('nota7')->nullable()->comment('valor de la nota');
            $table->double('procen7')->nullable()->comment('porcentaje de la nota');

            $table->double('nota8')->nullable()->comment('valor de la nota');
            $table->double('procen8')->nullable()->comment('porcentaje de la nota');

            $table->double('nota9')->nullable()->comment('valor de la nota');
            $table->double('procen9')->nullable()->comment('porcentaje de la nota');

            $table->double('nota10')->nullable()->comment('valor de la nota');
            $table->double('procen10')->nullable()->comment('porcentaje de la nota');

            $table->double('acumulado')->nullable()->comment('Acumulado del estudiante');

            $table->longText('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_detalle');
    }
};
