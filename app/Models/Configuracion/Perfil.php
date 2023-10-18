<?php

namespace App\Models\Configuracion;

use App\Models\Admin\PersonaMulticultural;
use App\Models\Admin\RegimenSalud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Perfil extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function estado() : BelongsTo
    {
        return $this->BelongsTo(Estado::class);
    }

    //Relacion uno a muchos inversa
    public function regimenSalud() : BelongsTo
    {
        return $this->BelongsTo(RegimenSalud::class);
    }

    //Relacion uno a muchos inversa
    public function sector() : BelongsTo
    {
        return $this->BelongsTo(Sector::class);
    }

    //Relacion uno a muchos inversa
    public function country() : BelongsTo
    {
        return $this->BelongsTo(Country::class);
    }

    /**
     * Relación muchos a muchos.
     * Perfiles con Multicultural
     */
    public function multicultural(): BelongsToMany
    {
        return $this->belongsToMany(PersonaMulticultural::class);
    }
}
