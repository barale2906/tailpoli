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
        Schema::table('controls', function (Blueprint $table) {
            $table->integer('diploma')->nullable()->after('overol')->comment('Verifica si la persona pago su diploma ya');
            $table->integer('ceremonia')->nullable()->after('overol')->comment('Verifica si la persona pago la ceremonia de grado');
            $table->date('fecha_grado')->nullable()->after('overol')->comment('registra la fecha en que se gradua la persona.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('controls', function (Blueprint $table) {
            $table->dropColumn('diploma');
            $table->dropColumn('ceremonia');
            $table->dropColumn('fecha_grado');
        });
    }
};
