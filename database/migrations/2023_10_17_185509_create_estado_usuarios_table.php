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
        Schema::create('estado_usuarios', function (Blueprint $table) {
            $table->comment('Estado del usuario estudiante');
            $table->id();
            $table->string('name')->comment('nombre del estado del usuario');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_usuarios');
    }
};
