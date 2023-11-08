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
        Schema::create('empresa', function (Blueprint $table) {
            $table->comment('Datos básicos legales de la empresa');
            $table->id();

            $table->string('nombre')->comment('nombre de la empresa');
            $table->string('direccion')->comment('dirección de la empresa');
            $table->string('nit')->comment('NIT de la empresa');
            $table->string('telefono')->comment('Teléfono de la empresa');
            $table->string('resolucionfact')->comment('resol vigente principal la empresa');
            $table->string('rl')->comment('Representante legal de la empresa');
            $table->string('documentoRl')->comment('documento del RL de la empresa');
            $table->string('telRl')->comment('telefono RL de la empresa');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
