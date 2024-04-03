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
        Schema::create('ayudas', function (Blueprint $table) {
            $table->comment('Árbol de ayudas por modulo');
            $table->id();
            $table->string('modulo')->comment('Modulo al que pertenece la ayuda');
            $table->string('titulo')->comment('tema a tratar en la ayuda');
            $table->longText('descripcion')->comment('detalle del tema de ayuda');
            $table->string('ruta')->comment('url del video respectio');
            $table->integer('status')->default(1)->comment('vigencia de la ayuda, 1 Vigente, 2 Obsoleta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayudas');
    }
};
