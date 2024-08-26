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
        Schema::create('cobranzarchivos', function (Blueprint $table) {
            $table->comment('Registro de la correspondencia enviada por cobranza');
            $table->id();

            $table->unsignedBigInteger('cobranza_id');
            $table->foreign('cobranza_id')->references('id')->on('cobranzas');

            $table->string('ruta')->comment('lugar donde esta archivo');
            $table->integer('etapa')->default(1)->comment('1 aviso, 2 negociacion, 3 reporte, 4 post-reporte');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cobranzarchivos');
    }
};
