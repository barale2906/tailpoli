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
        Schema::create('matricula_modulos_aprobacion', function (Blueprint $table) {
            $table->id();
            $table->integer('matricula_id')->comment('matricula registrada');
            $table->integer('alumno_id')->comment('usuario matriculado');
            $table->integer('modulo_id')->comment('modulo matriculado');
            $table->string('name')->comment('nombre del modulo');
            $table->boolean('dependencia')->default(false)->comment('false no depende de otros modulos, true depende de otros modulos');
            $table->boolean('aprobo')->default(false)->comment('false desaprobado, true aprobado');
            $table->longText('observaciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matricula_modulos_aprobacion');
    }
};
