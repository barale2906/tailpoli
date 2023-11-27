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
        Schema::create('conf_pag_otros_dets', function (Blueprint $table) {
            $table->comment('Crea detalles de pago para otros conceptos');
            $table->id();

            $table->unsignedBigInteger('conf_pag_otro_id');
            $table->foreign('conf_pag_otro_id')->references('id')->on('conf_pag_otros');

            $table->double('precio')->comment('valor del concepto');

            $table->boolean('status')->default(true)->comment('false inactiva, true activa');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conf_pag_otros_dets');
    }
};
