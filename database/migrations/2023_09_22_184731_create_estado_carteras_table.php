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
        Schema::create('estado_carteras', function (Blueprint $table) {
            $table->comment('Estados de cartera aplicables');
            $table->id();
            $table->string('name')->comment('nombre del estado de cartera');
            $table->boolean('status')->default(true)->comment('false Saldo Inactivo, true Saldo Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_carteras');
    }
};
