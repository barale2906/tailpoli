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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->comment('Encabezado control de asistencia');
            $table->id();

            $table->unsignedBigInteger('profesor_id');
            $table->foreign('profesor_id')->references('id')->on('users');

            $table->unsignedBigInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('grupos');

            $table->Integer('registros')->comment('Cantidad de clases');

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

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
