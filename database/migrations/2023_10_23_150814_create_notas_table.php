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
        Schema::create('notas', function (Blueprint $table) {
            $table->comment('Encabezado de las notas');
            $table->id();

            $table->unsignedBigInteger('profesor_id');
            $table->foreign('profesor_id')->references('id')->on('users');

            $table->unsignedBigInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('grupos');

            $table->string('nota1')->nullable()->comment('nombre de la nota');
            $table->double('porcen1')->nullable()->comment('porcentaje de la nota');

            $table->string('nota2')->nullable()->comment('nombre de la nota');
            $table->double('porcen2')->nullable()->comment('porcentaje de la nota');

            $table->string('nota3')->nullable()->comment('nombre de la nota');
            $table->double('porcen3')->nullable()->comment('porcentaje de la nota');

            $table->string('nota4')->nullable()->comment('nombre de la nota');
            $table->double('porcen4')->nullable()->comment('porcentaje de la nota');

            $table->string('nota5')->nullable()->comment('nombre de la nota');
            $table->double('porcen5')->nullable()->comment('porcentaje de la nota');

            $table->string('nota6')->nullable()->comment('nombre de la nota');
            $table->double('porcen6')->nullable()->comment('porcentaje de la nota');

            $table->string('nota7')->nullable()->comment('nombre de la nota');
            $table->double('porcen7')->nullable()->comment('porcentaje de la nota');

            $table->string('nota8')->nullable()->comment('nombre de la nota');
            $table->double('porcen8')->nullable()->comment('porcentaje de la nota');

            $table->string('nota9')->nullable()->comment('nombre de la nota');
            $table->double('porcen9')->nullable()->comment('porcentaje de la nota');

            $table->string('nota10')->nullable()->comment('nombre de la nota');
            $table->double('porcen10')->nullable()->comment('porcentaje de la nota');

            $table->longText('descripcion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
