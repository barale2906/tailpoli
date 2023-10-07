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
        Schema::create('modulos_dependencias', function (Blueprint $table) {
            $table->id();
            $table->integer('modulo_id')->comment('modulo dependendiente');
            $table->integer('modulodep_id')->comment('modulos de los que depende');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos_dependencias');
    }
};
