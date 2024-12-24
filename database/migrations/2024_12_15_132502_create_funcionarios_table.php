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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('cargo')->comment('Cargo al que esta contratado(a)');
            $table->integer('tipo_contrato')->comment('0 Indefinido, 1 inferior a un año, 2 Prestación de servicios, 3 obra labor');
            $table->string('educacion')->comment('nivel de escolaridad de la persona');
            $table->date('contrato')->comment('FEcha de contrato vigente');
            $table->double('salario')->comment('Salario actual');
            $table->date('fecha_inicio')->comment('Fecha de inicio vigente');
            $table->date('fecha_fin')->nullable()->comment('Fecha de fin vigente');
            $table->date('fecha_otrosi')->nullable()->comment('Fecha último Otrosí');
            $table->date('carta_finaliza')->nullable()->comment('FEcha en que le envío la carta');
            $table->string('banco')->comment('Banco al que se le debe pagar');
            $table->string('cuenta')->comment('Número de cuenta.');
            $table->string('arl')->comment('ARL al que esta afiliada la persona');
            $table->double('porcen_arl')->comment('porcentaje ARL');
            $table->string('pension')->comment('Pensiones');
            $table->string('eps')->comment('salud');
            $table->string('caja')->comment('caja compnesación');
            $table->date('dotacion')->nullable()->comment('Fecha entrega dotación');
            $table->string('conyuge')->comment('Conyuge');
            $table->integer('status')->default(1)->comment('1 Activo, 2 Inactivo, ');
            $table->longText('observaciones')->comment('Datos pertinentes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
