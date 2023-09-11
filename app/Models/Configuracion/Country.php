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
        return $this->hasMany(App\Models\Configuracion\Sector::class);
    }

    /**
     * Relación uno  muchos a través de
     * Obtener todos los estados para este país.
     */
    public function states(): HasManyThrough
    {
        return $this->hasManyThrough(App\Models\Configuracion\Sector::class, App\Models\Configuracion\State::class);
    }
}
