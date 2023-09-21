<?php

namespace App\Models\Academico;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * Horarios de este horario
     */
    public function horarios(): BelongsToMany
    {
        return $this->belongsToMany(Horario::class);
    }

    /**
     * Relación muchos a muchos.
     * Profesores de este grupo
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(User::class);

    }

    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    //Relacion uno a muchos inversa
    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
