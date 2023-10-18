<?php

namespace App\Models\Admin;

use App\Models\Configuracion\Perfil;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegimenSalud extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos
    public function perfiles(): HasMany
    {
        return $this->hasMany(Perfil::class);
    }

}
