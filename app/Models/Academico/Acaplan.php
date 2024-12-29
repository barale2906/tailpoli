<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Acaplan extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function grupo() : BelongsTo
    {
        return $this->BelongsTo(Grupo::class);
    }

    //Relacion uno a muchos inversa
    public function ciclo() : BelongsTo
    {
        return $this->BelongsTo(Ciclo::class);
    }

    /**
     * Relación muchos a muchos.
     * Detalles del plan
     */
    public function cronodetas(): HasMany
    {
        return $this->hasMany(Cronodeta::class);
    }
}
