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
        Schema::create('crms', function (Blueprint $table) {
            $table->comment('Registra la gestión por CRM');
            $table->id();

            $table->unsignedBigInteger('gestiona_id');
            $table->foreign('gestiona_id')->references('id')->on('users');

            $table->unsignedBigInteger('sector_id');
            $table->foreign('sector_id')->references('id')->on('sectors');

            $table->date('fecha_carga')->comment('fecha de carga al sistema');
            $table->date('fecha_registro')->comment('fecha de registro del usuario como lead');
            $table->date('fecha_gestion')->comment('última fecha de gestión');
            $table->integer('mes')->comment('mes de asignación');
            $table->string('curso')->comment('curso al cuál esta interesado');
            $table->string('name')->comment('nombre del alumno');
            $table->string('telefono')->comment('telefono alumno');
            $table->string('email')->comment('email alumno');
            $table->longText('historial')->comment('registro de gestión');
            $table->integer('status')->default(1)->comment('1 creado, 2 interesado, 3 pendiente por matricular, 4 Matriculado, 5 declinado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crms');
    }
};
