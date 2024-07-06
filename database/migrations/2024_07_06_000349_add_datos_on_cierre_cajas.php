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
        Schema::table('cierre_cajas', function (Blueprint $table) {

            $table->double('efectivo')->nullable()->after('valor_total')->comment('Venta total en efectivo.');
            $table->double('efectivo_descuento')->nullable()->after('valor_total')->comment('descuento aplicado en efectivo.');
            $table->double('efectivo_disponible')->nullable()->after('valor_total')->comment('Efectivo después de descuentos y otros gastos');
            $table->double('cobro_tarjeta')->nullable()->after('valor_total')->comment('ingreso por comisiones de venta por tarjeta');
            $table->double('tarjeta')->nullable()->after('valor_total')->comment('Venta total con tarjetas de productos propios');
            $table->double('descuentotal')->nullable()->after('valor_total')->comment('DEscuento aplicado en total.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cierre_cajas', function (Blueprint $table) {

            $table->dropColumn('efectivo');
            $table->dropColumn('efectivo_descuento');
            $table->dropColumn('efectivo_disponible');
            $table->dropColumn('cobro_tarjeta');
            $table->dropColumn('tarjeta');
            $table->dropColumn('descuentotal');

        });
    }
};
