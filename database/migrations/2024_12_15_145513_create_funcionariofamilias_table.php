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
        Schema::create('funcionariofamilias', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('funcionario_id');
            $table->foreign('funcionario_id')->references('id')->on('funcionarios');

            $table->string('name')->comment('nombre del familiar');
            $table->integer('edad')->comment('Edad');
            $table->string('telefono')->nullable()->comment('numero de contacto');
            $table->integer('relacion')->comment('mamá papá, hijo,...');
            $table->integer('beneficiario')->comment('1 si, 2 no');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionariofamilias');
    }
};
