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
        Schema::create('perfils', function (Blueprint $table) {
            $table->comment('Perfil de los usuarios de la empresa');
            $table->id();

            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('sector_id');
            $table->foreign('sector_id')->references('id')->on('sectors');

            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id')->on('estados');

            $table->unsignedBigInteger('regimen_salud_id');
            $table->foreign('regimen_salud_id')->references('id')->on('regimen_saluds');

            $table->string('tipo_documento')->comment('tipo documento de identidad');
            $table->string('documento')->comment('numero documento de identidad');
            $table->string('nombre')->comment('nombre del usuario');
            $table->string('apellido')->comment('apellido del usuario');

            $table->date('fecha_documento')->nullable()->comment('expedición documento de identidad');
            $table->string('lugar_expedicion')->nullable()->comment('lugar expedición documento de identidad');

            $table->longtext('direccion')->nullable()->comment('direccion del usuario');
            $table->date('fecha_nacimiento')->nullable()->comment('fecha de nacimiento');
            $table->string('barrio')->nullable()->comment('barrio - sector residencia');
            $table->string('celular')->nullable()->comment('celular');
            $table->string('wa')->nullable()->comment('WhatsApp');
            $table->string('fijo')->nullable()->comment('fijo');
            $table->string('email')->nullable()->comment('email usuario');
            $table->string('contacto')->nullable()->comment('Nombre y apellido persona de contacto');
            $table->string('documento_contacto')->nullable()->comment('documento persona de contacto');
            $table->string('parentesco_contacto')->nullable()->comment('Parentesco persona de contacto');
            $table->string('telefono_contacto')->nullable()->comment('telefono persona de contacto');
            $table->string('talla')->nullable()->comment('talla usuario');
            $table->string('calzado')->nullable()->comment('talla zapato');
            $table->string('genero')->nullable()->comment('genero usuario');
            $table->string('estado_civil')->nullable()->comment('estado civil usuario');
            $table->string('estrato')->nullable()->comment('estrato socioeconomico usuario');
            $table->string('nivel_educativo')->nullable()->comment('nivel educativo usuario');
            $table->string('ocupacion')->nullable()->comment('ocupacion usuario');
            $table->string('discapacidad')->nullable()->comment('discapacidad usuario');
            $table->longtext('enfermedad')->nullable()->comment('enfermedades del usuario');
            $table->string('empresa_usuario')->nullable()->comment('empresa donde trabaja usuario');
            $table->string('autoriza_imagen')->nullable()->comment('autoriza uso imagen usuario');
            $table->string('carnet')->nullable()->comment('Especifica si tiene carnet el usuario');
            $table->string('arl_usuario')->nullable()->comment('ARL usuario');
            $table->string('rh_usuario')->nullable()->comment('RH usuario');
            $table->string('url_foto_usuario')->nullable()->comment('url foto usuario');
            $table->string('sorteo_usuario')->nullable()->comment('Ticket sorteo usuario');
            $table->boolean('aprobo')->default(true)->comment('false inactivo, true activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfils');
    }
};
