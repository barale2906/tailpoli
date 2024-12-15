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
        Schema::create('funcionariosoportes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('funcionario_id');
            $table->foreign('funcionario_id')->references('id')->on('funcionarios');

            $table->date('fecha_documento')->comment('fecha de generación del documento');
            $table->string('name')->comment('nombre del documento');
            $table->string('ruta')->comment('ruta del documento');
            $table->integer('status')->default(1)->comment('1 Vigente, 0 Obsoleto');
            $table->integer('tipo')->comment('contrato, otrosi, etc');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionariosoportes');
    }
};
