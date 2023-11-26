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

            $table->string('fecha1')->nullable()->comment('fecha de control');
            $table->string('fecha2')->nullable()->comment('fecha de control');
            $table->string('fecha3')->nullable()->comment('fecha de control');
            $table->string('fecha4')->nullable()->comment('fecha de control');

            $table->string('fecha5')->nullable()->comment('fecha de control');
            $table->string('fecha6')->nullable()->comment('fecha de control');
            $table->string('fecha7')->nullable()->comment('fecha de control');
            $table->string('fecha8')->nullable()->comment('fecha de control');

            $table->string('fecha9')->nullable()->comment('fecha de control');
            $table->string('fecha10')->nullable()->comment('fecha de control');
            $table->string('fecha11')->nullable()->comment('fecha de control');
            $table->string('fecha12')->nullable()->comment('fecha de control');

            $table->string('fecha13')->nullable()->comment('fecha de control');
            $table->string('fecha14')->nullable()->comment('fecha de control');
            $table->string('fecha15')->nullable()->comment('fecha de control');
            $table->string('fecha16')->nullable()->comment('fecha de control');

            $table->string('fecha17')->nullable()->comment('fecha de control');
            $table->string('fecha18')->nullable()->comment('fecha de control');
            $table->string('fecha19')->nullable()->comment('fecha de control');
            $table->string('fecha20')->nullable()->comment('fecha de control');

            $table->string('fecha21')->nullable()->comment('fecha de control');
            $table->string('fecha22')->nullable()->comment('fecha de control');
            $table->string('fecha23')->nullable()->comment('fecha de control');
            $table->string('fecha24')->nullable()->comment('fecha de control');

            $table->string('fecha25')->nullable()->comment('fecha de control');
            $table->string('fecha26')->nullable()->comment('fecha de control');
            $table->string('fecha27')->nullable()->comment('fecha de control');
            $table->string('fecha28')->nullable()->comment('fecha de control');

            $table->string('fecha29')->nullable()->comment('fecha de control');
            $table->string('fecha30')->nullable()->comment('fecha de control');
            $table->string('fecha31')->nullable()->comment('fecha de control');

            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');

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
