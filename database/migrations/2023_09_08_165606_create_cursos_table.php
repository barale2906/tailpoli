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
        Schema::create('cursos', function (Blueprint $table) {
            $table->comment('Cursos dictados por el instituto');
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('tipo')->comment('Técnico o Práctico');
            $table->double('duracion_horas');
            $table->double('duracion_meses');
            $table->boolean('correo')->default(true)->comment('false no se envia con los pagos, true si se envia con los pagos');
            $table->boolean('status')->default(true)->comment('false Inactivo, true activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
