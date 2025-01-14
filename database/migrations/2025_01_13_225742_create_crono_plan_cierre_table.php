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
        Schema::create('crono_plan_cierre', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('crono_id')->comment('id del cronograma detalle aplicado');
            $table->bigInteger('plan_id')->comment('id del detalle del plan aplicado.');
            $table->datetime('fecha_cierre')->comment('fecha en que se cerro la tarea');
            $table->datetime('fecha_crono')->comment('fecha de la clase');
            $table->integer('usuario')->comment('id usuario que registro');
            $table->string('nombre')->comment('usuario que registro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crono_plan_cierre');
    }
};
