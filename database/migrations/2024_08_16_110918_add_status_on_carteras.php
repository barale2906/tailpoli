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
            $table->integer('status_est')->default(2)->after('status')->comment('Estado del estudiante según tabla de estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carteras', function (Blueprint $table) {
            $table->dropColumn('status_est');
        });
    }
};
