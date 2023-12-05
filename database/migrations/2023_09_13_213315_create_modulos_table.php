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
        Schema::create('modulos', function (Blueprint $table) {
            $table->comment('modulos dentro de cada curso');
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('dependencia')->default(false)->comment('false no depende de otros modulos, true depende de otros modulos');
            $table->boolean('status')->default(true)->comment('false Inactivo, true activo');

            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('cursos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos');
    }
};
