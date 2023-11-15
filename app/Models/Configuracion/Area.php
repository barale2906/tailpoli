<?php

namespace App\Models\Configuracion;

use App\Models\Academico\Horario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a muchos.
     * áreas que componen la sede
     */
    public function sedes(): BelongsToMany
    {
        return $this->belongsToMany(Sede::class);
    }

    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class);
    }

}
