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
        Schema::create('configpago_modulo', function (Blueprint $table) {
            $table->id();
            $table->integer('config_id')->comment('configuracion de pago');
            $table->integer('modulo_id')->comment('modulo');
            $table->string('name')->comment('nombre del modulo asignado');
            $table->boolean('dependencia')->default(false)->comment('false no depende de otros modulos, true depende de otros modulos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configpago_modulo');
    }
};
