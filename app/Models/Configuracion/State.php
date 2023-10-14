<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function country() : BelongsTo
    {
        return $this->BelongsTo(Country::class);
    }

    //Relación uno a muchos
    public function sectors(): HasMany
    {
        return $this->hasMany(App\Models\Configuracion\Sector::class);
    }

    //Relación uno a muchos
    public function configpagos(): HasMany
    {
        return $this->hasMany(ConfiguracionPago::class);
    }


}
