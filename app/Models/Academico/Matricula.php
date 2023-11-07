<?php

namespace App\Models\Academico;

use App\Models\Configuracion\Sede;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matricula extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    //Relacion uno a muchos inversa
    public function creador() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function alumno() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function comercial() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function curso() : BelongsTo
    {
        return $this->BelongsTo(Curso::class);
    }

    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    //Relacion muchos a muchos
    public function grupos() : BelongsToMany
    {
        return $this->BelongsToMany(Grupo::class);
    }

    //Relación uno a muchos
    public function documentos(): HasMany
    {
        return $this->hasMany(Nota::class);
    }
}
