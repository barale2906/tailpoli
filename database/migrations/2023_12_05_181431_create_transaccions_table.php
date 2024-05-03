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
        Schema::create('transaccions', function (Blueprint $table) {
            $table->comment('Controla la gestión de las transacciones');
            $table->id();

            $table->unsignedBigInteger('creador_id');
            $table->foreign('creador_id')->references('id')->on('users');

            $table->unsignedBigInteger('gestionador_id');
            $table->foreign('gestionador_id')->references('id')->on('users');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes');

            $table->date('fecha')->comment('fecha de generación');
            $table->string('ruta')->comment('ruta del archivo');
            $table->string('extension')->comment('extension del archivo');
            $table->double('inventario')->nullable()->comment('registra el valor a descargar por inventario');
            $table->double('academico')->nullable()->comment('registra el valor a descargar por temas academicos');
            $table->longText('observaciones')->comment('Información para la correcta gestión');

            $table->integer('status')->default(1)->comment('1 Creada, 2 inventario, 3 devuelto, 4 gestionada');
            $table->boolean('status_academico')->default(false)->comment('false sin solucionar, true solucionado');
            $table->boolean('status_inventario')->default(false)->comment('false sin solucionar, true solucionado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaccions');
    }
};
