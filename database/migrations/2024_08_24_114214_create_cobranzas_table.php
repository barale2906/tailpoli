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
        Schema::create('cobranzas', function (Blueprint $table) {
            $table->comment('Control de la gestión de cobranzas');
            $table->id();

            $table->unsignedBigInteger('cartera_id');
            $table->foreign('cartera_id')->references('id')->on('carteras');

            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('users');

            $table->unsignedBigInteger('matricula_id');
            $table->foreign('matricula_id')->references('id')->on('matriculas');

            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('cursos');

            $table->unsignedBigInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes');

            $table->longText('correos')->nullable()->comment('Registra las fechas en que se envían los correos de cobranza y los apuntes respectivos.');
            $table->integer('dias')->comment('Va contando los días de mora del respectivo registro');
            $table->integer('diasreporte')->default(5)->comment('Cuenta regresiva envío a centrales');
            $table->double('saldo')->comment('Valor adeudado');
            $table->integer('etapa')->default(1)->comment('1 aviso, 2 negociacion, 3 reporte, 4 post-reporte');
            $table->integer('status')->comment('Muestra el estado de carteras');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cobranzas');
    }
};
