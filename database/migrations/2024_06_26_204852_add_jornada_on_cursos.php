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
        Schema::table('grupos', function (Blueprint $table) {

            $table->integer('jornada')->default(1)->after('inscritos')->comment('1 Mañana, 2 Tarde, 3 Noche, 4 Fin de semana');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupos', function (Blueprint $table) {

            $table->dropColumn('jornada');
        });
    }
};
