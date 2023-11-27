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
        Schema::create('conf_pag_otros', function (Blueprint $table) {
            $table->comment('Crea configuraciones de pago para otros conceptos');
            $table->id();

            $table->unsignedBigInteger('sector_id');
            $table->foreign('sector_id')->references('id')->on('sectors');

            $table->date('inicia')->comment('Fecha inicio de la vigencia de la configuracion');
            $table->date('finaliza')->comment('Fecha fin de la vigencia de la configuracion');
            $table->longText('descripcion')->comment('descripción de la lista de precios');

            $table->boolean('status')->default(true)->comment('false inactiva, true activa');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conf_pag_otros');
    }
};
