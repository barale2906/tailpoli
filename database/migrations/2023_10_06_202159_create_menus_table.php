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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nombre del menu');
            $table->string('identificaRuta')->comment('verifica si esta en esa ruta el navegador');
            $table->string('permiso')->comment('permiso de acceso al menu');
            $table->string('icono')->comment('icono del menu');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
