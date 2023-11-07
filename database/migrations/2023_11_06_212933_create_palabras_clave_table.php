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
        Schema::create('palabras_clave', function (Blueprint $table) {

            $table->comment('Palabras para la generación de los documentos');
            $table->id();

            $table->string('palabra')->unique()->comment('palabras guías');
            $table->string('descripcion')->comment('aclaración d elas palabras guía.');
            $table->boolean('status')->default(true)->comment('false inactiva, true activa');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('palabras_clave');
    }
};
