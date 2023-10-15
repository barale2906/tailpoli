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
        Schema::create('cierre_cajas', function (Blueprint $table) {
            $table->comment('Detalles de los cierres de caja');
            $table->id();
            $table->dateTime('fecha_cierre')->comment('Fecha del cierre');
            $table->double('valor_total')->comment('Valor total del cierre');
            $table->double('valor_reportado')->default(0)->comment('Valor en efectivo reportado por el cajero, sera cero (0) cuando el cierre lo haga coordinador');
            $table->longtext('observaciones')->comment('Observaciones al cierre');

            $table->double('valor_pensiones')->default(0)->comment('Valor total por itemes de cartera');
            $table->double('valor_efectivo')->default(0)->comment('Valor recibido en efectivo');
            $table->double('valor_tarjeta')->default(0)->comment('Valor recibido en tarjetas credito y debito');
            $table->double('valor_cheque')->default(0)->comment('Valor recibido en cheques');
            $table->double('valor_consignacion')->default(0)->comment('Valor recibido en transferencias consignaciones PSE');

            $table->double('valor_otros')->default(0)->comment('Valor total del cierre por otros conceptos');
            $table->double('valor_efectivo_o')->default(0)->comment('Valor recibido en efectivo por otros conceptos');
            $table->double('valor_tarjeta_o')->default(0)->comment('Valor recibido en tarjetas credito y debito por otros conceptos');
            $table->double('valor_cheque_o')->default(0)->comment('Valor recibido en cheques por otros conceptos');
            $table->double('valor_consignacion_o')->default(0)->comment('Valor recibido en transferencias consignaciones por otros conceptos');

            /* $table->double('valor_herramientas')->default(0)->comment('Valor total del cierre por herramienta');
            $table->double('valor_efectivo_h')->default(0)->comment('Valor recibido en efectivo por herramienta');
            $table->double('valor_tarjeta_h')->default(0)->comment('Valor recibido en tarjetas credito y debito por herramienta');
            $table->double('valor_cheque_h')->default(0)->comment('Valor recibido en cheques por herramienta');
            $table->double('valor_consignacion_h')->default(0)->comment('Valor recibido en transferencias consignaciones por herramienta'); */

            $table->boolean('status')->default(false)->comment('false Precierre, true cierre');

            $table->unsignedBigInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes');

            $table->unsignedBigInteger('cajero_id');
            $table->foreign('cajero_id')->references('id')->on('users');

            $table->unsignedBigInteger('coorcaja_id');
            $table->foreign('coorcaja_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierre_cajas');
    }
};
