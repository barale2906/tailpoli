<?php

namespace App\Models\Configuracion;

use App\Models\Financiera\ConfiguracionPago;
use App\Models\Financiera\ConfPagOtros;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function state() : BelongsTo
    {
        return $this->BelongsTo(State::class);
    }

    //Relación uno a muchos
    public function configpagos(): HasMany
    {
        return $this->hasMany(ConfiguracionPago::class);
    }

    //Relación uno a muchos
    public function configotros(): HasMany
    {
        return $this->hasMany(ConfPagOtros::class);
    }

    //Relación uno a muchos
    public function sedes(): HasMany
    {
        return $this->hasMany(Sede::class);
    }

    //Relación uno a muchos
    public function perfiles(): HasMany
    {
        return $this->hasMany(Perfil::class);
    }
}
