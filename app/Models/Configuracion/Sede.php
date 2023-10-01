<?php

namespace App\Models\Configuracion;

use App\Models\Academico\Grupo;
use App\Models\Financiera\ConfiguracionPago;
use App\Models\Financiera\ReciboPago;
use App\Models\Inventario\Almacen;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sede extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function sector() : BelongsTo
    {
        return $this->BelongsTo(Sector::class);
    }

    /**
     * Relación muchos a muchos.
     * áreas que componen la sede
     */
    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(Area::class);
    }

    /**
     * Relación muchos a muchos.
     * usuarios admninistradtivos que gestionan la sede
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    //Relación uno a muchos
    public function configpagos(): HasMany
    {
        return $this->hasMany(ConfiguracionPago::class);
    }

    //Relación uno a muchos
    public function grupos(): HasMany
    {
        return $this->hasMany(Grupo::class);
    }

    //Relación uno a muchos
    public function almacenes(): HasMany
    {
        return $this->hasMany(Almacen::class);
    }

    //Relación uno a muchos
    public function recibos(): HasMany
    {
        return $this->hasMany(ReciboPago::class);
    }
}
