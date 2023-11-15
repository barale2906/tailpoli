<?php

namespace App\Models\Academico;

use App\Models\Configuracion\Area;
use App\Models\Configuracion\Sede;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a muchos.
     * áreas que componen la sede
     */
    public function area(): BelongsTo
    {
        return $this->BelongsTo(Area::class);
    }

    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    /**
     * Relación muchos a muchos.
     * Grupos de este modulo
     */
    public function grupo(): BelongsTo
    {
        return $this->BelongsTo(Grupo::class);
    }


}
