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
        Schema::create('grupos', function (Blueprint $table) {
            $table->comment('Grupos para dictar cada modulo');
            $table->id();
            $table->string('name')->comment('nombre del grupo');
            $table->date('start_date')->comment('Fecha inicio del grupo');
            $table->date('finish_date')->comment('Fecha final del grupo');
            $table->integer('quantity_limit')->comment('Cantidad máxima de estudiantes');
            $table->integer('inscritos')->default(0)->comment('Cantidad de estudiantes inscritos');
            $table->boolean('status')->default(true)->comment('false Saldo Inactivo, true Saldo Activo');

            $table->unsignedBigInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes');

            $table->unsignedBigInteger('profesor_id');
            $table->foreign('profesor_id')->references('id')->on('users');

            $table->unsignedBigInteger('modulo_id');
            $table->foreign('modulo_id')->references('id')->on('modulos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
