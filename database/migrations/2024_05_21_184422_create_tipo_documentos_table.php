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
        Schema::create('tipo_documentos', function (Blueprint $table) {
            $table->comment('');
            $table->id();
            $table->string('name')->unique()->comment('nombre del tipo de documento');
            $table->longText('descripcion')->comment('Funcionalidad del documento');
            $table->boolean('status')->default(true)->comment('false inactiva, true activa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_documentos');
    }
};
