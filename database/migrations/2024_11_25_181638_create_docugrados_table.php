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
        Schema::create('docugrados', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('matricula_id');
            $table->foreign('matricula_id')->references('id')->on('matriculas');

            $table->unsignedBigInteger('graduando_id');
            $table->foreign('graduando_id')->references('id')->on('users');

            $table->string('titulo')->comment('Titulo obtenido');
            $table->integer('tipo_curso')->default(1)->comment('1 Práctico, 2 Técnico, 3 Indiferente');
            $table->date('fecha_grado')->comment('Fecha de la graduación');
            $table->string('acta')->comment('Número del acta');
            $table->date('fecha_acta')->comment('Fecha del acta');
            $table->integer('alumnos_graduados')->nullable()->comment('Alumnos graduados con esa acta');
            $table->string('alumno_inicia')->nullable()->comment('Primer alumno registrado en el acta');
            $table->string('alumno_finaliza')->nullable()->comment('último alumno registrado en el acta');
            $table->string('folio_acta')->nullable()->comment('Número de folio del acta si aplica');
            $table->string('libro')->nullable()->comment('libro de registro');

            $table->longText('observaciones')->comment('Datos del historial de uso de este registro.');
            $table->integer('user_gestiona')->comment('Id del último usuario que uso este registro.');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docugrados');
    }
};
