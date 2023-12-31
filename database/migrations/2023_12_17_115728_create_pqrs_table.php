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
        Schema::create('pqrs', function (Blueprint $table) {
            $table->comment('Gestión con los estudiantes - observador');
            $table->id();

            $table->unsignedBigInteger('estudiante_id');
            $table->foreign('estudiante_id')->references('id')->on('users');

            $table->unsignedBigInteger('gestion_id');
            $table->foreign('gestion_id')->references('id')->on('users');

            $table->dateTime('fecha')->comment('fecha de generación');
            $table->integer('opcion')->default(1)->comment('1 Gestion, 2 Petición, 3 Queja, 4 Reclamo, 5 Sugerencia, 6 Felicitación');
            $table->integer('tipo')->comment('1 gestión, 2 pagos, 3 notas, 4 acádemico, 5 Profesor, 6 Planta, 7 Talleres, 8 Administración, 9 Observador, 10 Practicas empresariales');
            $table->longText('observaciones')->comment('observaciones');
            $table->string('ruta_solicita')->nullable()->comment('ruta de los archivos adjuntos de solicitud');
            $table->string('ruta_respuesta')->nullable()->comment('ruta de los archivos adjuntos de respuesta');
            $table->integer('status')->default(1)->comment('1 creado, 2 asignado, 3 en gestión, 4 cerrado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pqrs');
    }
};
