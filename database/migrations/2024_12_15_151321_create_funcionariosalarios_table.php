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
        Schema::create('funcionariosalarios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('funcionario_id');
            $table->foreign('funcionario_id')->references('id')->on('funcionarios');

            $table->double('basico')->comment('Salario base del funcionario');
            $table->double('subsidio_transporte')->comment('subsidio ley');
            $table->double('otros_subisidios')->nullable()->comment('Otros aplicables conectividad, calzado');
            $table->double('bonificacion')->nullable()->comment('bonificación');
            $table->date('vigencia')->comment('Inicio en vigencia de este salario');
            $table->longText('observaciones');
            $table->integer('status')->default(1)->comment('1 activo, 0 Inactivo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionariosalarios');
    }
};
