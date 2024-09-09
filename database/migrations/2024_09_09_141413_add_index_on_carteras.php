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
        Schema::table('carteras', function (Blueprint $table) {
            $table->index('status_est');
            $table->index('estado_cartera_id');
            $table->index('matricula_id');
            $table->index('responsable_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carteras', function (Blueprint $table) {
            // Eliminar los índices
            $table->dropIndex(['status_est']);
            $table->dropIndex(['estado_cartera_id']);
            $table->dropIndex(['matricula_id']);
            $table->dropIndex(['responsable_id']);
        });
    }
};
