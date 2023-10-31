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
        Schema::create('asistencia_detalle', function (Blueprint $table) {
            $table->comment('control de las notas generadas por cada estudiante en los grupos');
            $table->id();

            $table->unsignedBigInteger('asistencia_id');
            $table->foreign('asistencia_id')->references('id')->on('asistencias');

            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('users');
            $table->string('alumno');

            $table->unsignedBigInteger('profesor_id');
            $table->foreign('profesor_id')->references('id')->on('users');
            $table->string('profesor');

            $table->unsignedBigInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('grupos');
            $table->string('grupo');

            $table->date('fecha1')->nullable()->comment('fecha de control');
            $table->date('fecha2')->nullable()->comment('fecha de control');
            $table->date('fecha3')->nullable()->comment('fecha de control');
            $table->date('fecha4')->nullable()->comment('fecha de control');

            $table->date('fecha5')->nullable()->comment('fecha de control');
            $table->date('fecha6')->nullable()->comment('fecha de control');
            $table->date('fecha7')->nullable()->comment('fecha de control');
            $table->date('fecha8')->nullable()->comment('fecha de control');

            $table->date('fecha9')->nullable()->comment('fecha de control');
            $table->date('fecha10')->nullable()->comment('fecha de control');
            $table->date('fecha11')->nullable()->comment('fecha de control');
            $table->date('fecha12')->nullable()->comment('fecha de control');

            $table->date('fecha13')->nullable()->comment('fecha de control');
            $table->date('fecha14')->nullable()->comment('fecha de control');
            $table->date('fecha15')->nullable()->comment('fecha de control');
            $table->date('fecha16')->nullable()->comment('fecha de control');

            $table->date('fecha17')->nullable()->comment('fecha de control');
            $table->date('fecha18')->nullable()->comment('fecha de control');
            $table->date('fecha19')->nullable()->comment('fecha de control');
            $table->date('fecha20')->nullable()->comment('fecha de control');

            $table->date('fecha21')->nullable()->comment('fecha de control');
            $table->date('fecha22')->nullable()->comment('fecha de control');
            $table->date('fecha23')->nullable()->comment('fecha de control');
            $table->date('fecha24')->nullable()->comment('fecha de control');

            $table->date('fecha25')->nullable()->comment('fecha de control');
            $table->date('fecha26')->nullable()->comment('fecha de control');
            $table->date('fecha27')->nullable()->comment('fecha de control');
            $table->date('fecha28')->nullable()->comment('fecha de control');

            $table->date('fecha29')->nullable()->comment('fecha de control');
            $table->date('fecha30')->nullable()->comment('fecha de control');
            $table->date('fecha31')->nullable()->comment('fecha de control');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_detalle');
    }
};
