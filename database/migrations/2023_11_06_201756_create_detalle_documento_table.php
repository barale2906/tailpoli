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
        Schema::create('detalle_documento', function (Blueprint $table) {

            $table->comment('detalle de cada documento');
            $table->id();

            $table->unsignedBigInteger('documento_id');
            $table->foreign('documento_id')->references('id')->on('documentos');

            $table->string('tipodetalle')->comment('encabezado, clausula, parágrafo, firma');
            $table->longText('contenido')->comment('información a presentar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_documento');
    }
};
