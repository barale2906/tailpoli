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
        Schema::create('controls', function (Blueprint $table) {
            $table->comment('Controla el estado de los estudiantes para cada ciclo');
            $table->id();

            $table->date('inicia')->comment('Fecha cuando inicia clases');
            $table->string('overol')->default('no')->comment('si, no, pendiente');
            $table->integer('estado_cartera')->default(1)->comment('1 Al día, 2 Verificar transferencia, 3 mora, 4 proximo a vencer, 5 pago total');
            $table->date('ultimo_pago')->nullable()->comment('Fecha ultimo pago registrado');
            $table->date('ultima_asistencia')->nullable()->comment('Fecha ultima asistencia');
            $table->double('mora')->default(0)->comment('Saldo que tenga en mora el estudiante');
            $table->longText('observaciones')->comment('describe todo lo que ocurra con el estudiante en el proceso');
            $table->integer('status_est')->default(1)->comment('1 activo, 2 finalizado, 3 aplazado, 4 desertado, 5 reingreso');
            $table->boolean('status')->default(true)->comment('false inactiva, true activa');

            $table->unsignedBigInteger('ciclo_id');
            $table->foreign('ciclo_id')->references('id')->on('ciclos');

            $table->unsignedBigInteger('estudiante_id');
            $table->foreign('estudiante_id')->references('id')->on('users');

            $table->unsignedBigInteger('matricula_id');
            $table->foreign('matricula_id')->references('id')->on('matriculas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controls');
    }
};
