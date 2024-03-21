<?php

namespace App\Models\Academico;

use App\Models\Configuracion\Sede;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ciclo extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    //Relacion uno a muchos inversa
    public function curso() : BelongsTo
    {
        return $this->BelongsTo(Curso::class);
    }

    //Relacion uno a muchos inversa
    public function creador() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relación uno a muchos
    public function control(): HasOne
    {
        return $this->hasOne(Control::class);
    }

    //Relación uno a muchos
    public function ciclogrupos(): HasMany
    {
        return $this->hasMany(Ciclogrupo::class);
    }
}
