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
        Schema::create('regimen_saluds', function (Blueprint $table) {
            $table->comment('Regímenes de salud aplicable');
            $table->id();
            $table->string('name')->unique();
            $table->integer('status')->default(1)->comment('0 Inactivo, 1 activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regimen_saluds');
    }
};
