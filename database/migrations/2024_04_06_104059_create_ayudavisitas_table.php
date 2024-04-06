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
        Schema::create('ayudavisitas', function (Blueprint $table) {
            $table->id();
            $table->integer('visitante')->comment('id del lector');
            $table->string('nombre_visitante')->comment('nombre del visitante');
            $table->string('tema')->comment('tema a aprender');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayudavisitas');
    }
};
