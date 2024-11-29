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
        Schema::create('titulotecnico', function (Blueprint $table) {
            $table->id();
            $table->integer('curso_id')->comment('id del curso tecnico respectivo');
            $table->integer('tipo')->default(1)->comment('1 titulo, 2 temas');
            $table->longText('descripcion')->comment('Descripcion del titulo obtenido');
            $table->integer('status')->default(1)->comment('1 vigente, 0 Obsoleto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titulotecnico');
    }
};
