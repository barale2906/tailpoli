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
        Schema::create('submenus', function (Blueprint $table) {
            $table->id();
            $table->string('ruta')->comment('Ruta del submenu');
            $table->string('name')->comment('Nombre del submenu');
            $table->string('identificaRuta')->comment('verifica si esta en esa ruta el navegador');
            $table->string('permiso')->comment('permiso de acceso al submenu');
            $table->string('icono')->comment('icono del submenu');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');

            $table->unsignedBigInteger('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submenus');
    }
};
