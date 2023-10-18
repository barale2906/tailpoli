<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    use HasFactory;

    protected $fillable =['name', 'status'];

    //Relación uno a muchos
    public function sectors(): HasMany
    {
        return $this->hasMany(Sector::class);
    }

    //Relación uno a muchos
    public function perfiles(): HasMany
    {
        return $this->hasMany(Perfil::class);
    }

    /**
     * Relación uno  muchos a través de
     * Obtener todos los estados para este país.
     */
    public function states(): HasManyThrough
    {
        return $this->hasManyThrough(Sector::class, State::class);
    }
}
