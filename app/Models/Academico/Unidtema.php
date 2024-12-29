<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unidtema extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function unidad() : BelongsTo
    {
        return $this->BelongsTo(Unidade::class);
    }

    /**
     * Relación muchos a muchos.
     * detalles del cronograma para el tema
     */
    public function crodetas(): HasMany
    {
        return $this->hasMany(Cronodeta::class);
    }

    /**
     * Relación muchos a muchos.
     * Temas de la unidad
     */
    public function plandeta(): HasMany
    {
        return $this->hasMany(Acaplandeta::class);
    }
}
