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
        Schema::table('palabras_clave', function (Blueprint $table) {

            $table->integer('control')->default(0)->after('id')->comment('0 todos, 1 matriculas, 2 graduaciones');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('palabras_clave', function (Blueprint $table) {

            $table->dropColumn('control');

        });
    }
};
