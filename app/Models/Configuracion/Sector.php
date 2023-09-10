<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function state() : BelongsTo
    {
        return $this->BelongsTo(State::class);
    }

    //Relación uno a muchos
    public function sedes(): HasMany
    {
        return $this->hasMany(Sede::class);
    }
}
