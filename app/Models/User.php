<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Academico\Grupo;
use App\Models\Academico\Matricula;
use App\Models\Academico\Nota;
use App\Models\Configuracion\Perfil;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ReciboPago;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'documento',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    //Relación uno a muchos
    public function perfil(): HasOne
    {
        return $this->hasOne(Perfil::class);
    }

    //Relación uno a muchos
    public function inventarios(): HasMany
    {
        return $this->hasMany(Inventario::class);
    }

    //Relación uno a muchos
    public function grupos(): HasMany
    {
        return $this->hasMany(Grupo::class);
    }

    /**
     * Relación muchos a muchos.
     * alumnos por cada grupo
     */
    public function alumnosGrupo(): BelongsToMany
    {
        return $this->belongsToMany(Grupo::class);

    }

    //Relación uno a muchos
    public function matriculAlumno(): HasMany
    {
        return $this->hasMany(Matricula::class);
    }

    //Relación uno a muchos
    public function matriculaCreador(): HasMany
    {
        return $this->hasMany(Matricula::class);
    }

    //Relación uno a muchos
    public function matriculaComercial(): HasMany
    {
        return $this->hasMany(Matricula::class);
    }

    //Relación uno a muchos
    public function alumnoNotas(): HasMany
    {
        return $this->hasMany(Nota::class);
    }

    //Relación uno a muchos
    public function profesorNotas(): HasMany
    {
        return $this->hasMany(Nota::class);
    }

    //Relación uno a muchos
    public function responsables(): HasMany
    {
        return $this->hasMany(Cartera::class);
    }

    //Relación uno a muchos
    public function creadors(): HasMany
    {
        return $this->hasMany(ReciboPago::class);
    }

    //Relación uno a muchos
    public function pagas(): HasMany
    {
        return $this->hasMany(ReciboPago::class);
    }

    //Relación uno a muchos
    public function cajeros(): HasMany
    {
        return $this->hasMany(CierreCaja::class);
    }

    //Relación uno a muchos
    public function coorcajas(): HasMany
    {
        return $this->hasMany(CierreCaja::class);
    }

    /**
     * Relación muchos a muchos.
     * usuarios que gestionan las sedes
     */
    public function sedes(): BelongsToMany
    {
        return $this->belongsToMany(Sede::class);
    }
}
