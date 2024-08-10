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
        Schema::table('ayudas', function (Blueprint $table) {
            $table->integer('modulo_id')->default(1)->after('modulo')->comment('id del modulo rspectivo');
            $table->integer('tipo')->default(1)->after('modulo_id')->comment('1 Video, 2 PDF');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ayudas', function (Blueprint $table) {
            $table->dropColumn('modulo_id');
            $table->dropColumn('tipo');
        });
    }
};
