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
        Schema::create('perfil_persona_multicultural', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('perfil_id');
            $table->foreign('perfil_id')->references('id')->on('perfils');

            $table->unsignedBigInteger('persona_multicultural_id');
            $table->foreign('persona_multicultural_id')->references('id')->on('persona_multiculturals');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfil_persona_multicultural');
    }
};
