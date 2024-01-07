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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('documento')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->integer('caso_especial')->default(0)->comment('0 normal, 1 reprobo modulo, 2 reintegrado');
            $table->boolean('status')->default(true)->comment('false Saldo Inactivo, true Saldo Activo');
            $table->integer('rol_id')->comment('1 Superusuario, 2 Administrador, 3 Coordinador, 4 Auxiliar, 5 Profesor, 6 Estudiante');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
