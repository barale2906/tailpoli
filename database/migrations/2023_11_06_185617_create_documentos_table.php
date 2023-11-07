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
        Schema::create('documentos', function (Blueprint $table) {

            $table->comment('definición de los documentos');
            $table->id();

            $table->unsignedBigInteger('matricula_id');
            $table->foreign('matricula_id')->references('id')->on('matriculas');

            $table->unsignedBigInteger('creador_id');
            $table->foreign('creador_id')->references('id')->on('users');


            $table->date('fecha')->nullable()->comment('Fecha en que inicia a funcionar el dcoumento');
            $table->string('tipo')->nullable()->comment('tipo de documento contrato, pagare, certificado estudio');
            $table->string('nombre')->nullable()->comment('nombre del documento');
            $table->string('titulo')->nullable()->comment('titulo del documento');

            $table->boolean('integer')->default(1)->comment('1 Elaboración, 2 aprobado, 3 activo, 4 obsoleto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
