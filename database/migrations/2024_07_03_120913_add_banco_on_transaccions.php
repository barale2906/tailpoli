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
        Schema::table('transaccions', function (Blueprint $table) {

            $table->string('banco')->default('')->after('total')->comment('Banco donde se consigno el dinero');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaccions', function (Blueprint $table) {

            $table->dropColumn('banco');
        });
    }
};
