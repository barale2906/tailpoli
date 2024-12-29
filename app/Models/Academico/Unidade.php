<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unidade extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function modulo() : BelongsTo
    {
        return $this->BelongsTo(Modulo::class);
    }

    /**
     * Relación muchos a muchos.
     * Temas de la unidad
     */
    public function temas(): HasMany
    {
        return $this->hasMany(Unidtema::class);
    }
}
