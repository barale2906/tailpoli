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
        Schema::table('recibo_pagos', function (Blueprint $table) {
            $table->double('descuento')->default(0)->after('valor_total')->comment('descuentos aplicados al pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recibo_pagos', function (Blueprint $table) {
            $table->dropColumn('descuento');
        });
    }
};
