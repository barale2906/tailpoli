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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes');

            $table->string('name')->comment('Nombre de la cuenta');
            $table->string('numero_cuenta')->comment('número de la cuenta');
            $table->string('tipo')->comment('Clase de movimiento, efectivo o transferencia');
            $table->string('banco')->nullable()->comment('Banco cuando hay transferencia');
            $table->integer('status')->default(1)->comment('1 activo, o inactivo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};
