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
        Schema::create('estados', function (Blueprint $table) {
            $table->comment('Estado de los usuarios');
            $table->id();
            $table->string('name')->comment('nombre del estado del usuario');
            $table->string('tipo')->comment('Aplicable a tipos de usuario');
            $table->boolean('status')->default(true)->comment('false Inactivo, true activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
