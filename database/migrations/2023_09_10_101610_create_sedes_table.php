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
        Schema::create('sedes', function (Blueprint $table) {
            $table->comment('Sedes dentro de cada ciudad');
            $table->id();

            $table->string('name')->unique()->comment('nombre de la sede, debe ser única');
            $table->string('address');
            $table->string('phone');
            $table->string('nit');
            $table->string('portfolio_assistant_name')->comment('nombre de la persona encargada');
            $table->string('portfolio_assistant_phone')->comment('Teléfono de la persona encargada');
            $table->string('portfolio_assistant_email')->comment('email de la persona encargada');
            $table->time('start')->comment('hora de apertura');
            $table->time('finish')->comment('hora de cierre');
            $table->boolean('status')->default(true)->comment('false Inactivo, true activo');

            $table->unsignedBigInteger('sector_id');
            $table->foreign('sector_id')->references('id')->on('sectors');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sedes');
    }
};
