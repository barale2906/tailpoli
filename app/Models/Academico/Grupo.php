<?php

namespace App\Models\Academico;

use App\Models\Configuracion\Sede;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grupo extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a muchos.
     * Grupos de este modulo
     */
    public function modulo(): BelongsTo
    {
        return $this->belongsTo(Modulo::class);
    }

    /**
     * Relación muchos a muchos.
     * Profesores de este grupo
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(User::class);

    }

    /**
     * Relación muchos a muchos.
     * Grupos de este modulo
     */
    public function ciclos(): BelongsToMany
    {
        return $this->belongsToMany(Ciclo::class);
    }

    //Relación uno a muchos
    public function Notas(): HasMany
    {
        return $this->hasMany(Nota::class);
    }

    //Relación uno a muchos
    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class);
    }

    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    //Relacion uno a muchos inversa
    public function profesor() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function matriculas() : BelongsToMany
    {
        return $this->BelongsToMany(Matricula::class);
    }
}
