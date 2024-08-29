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
        Schema::create('cuotaplaza', function (Blueprint $table) {
            $table->id();
            $table->double('valor')->comment('valor cuota de aplazam,iento');
            $table->string('cambio')->comment('Nombre de quien creo / Anulo la cuota');
            $table->integer('status')->default(1)->comment('1 activo, 2 inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuotaplaza');
    }
};
