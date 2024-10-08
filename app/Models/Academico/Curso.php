<?php

namespace App\Models\Academico;

use App\Models\Financiera\Cobranza;
use App\Models\Financiera\ConfiguracionPago;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos
    public function modulos(): HasMany
    {
        return $this->hasMany(Modulo::class);
    }

    //Relación uno a muchos
    public function matriculas(): HasMany
    {
        return $this->hasMany(Matricula::class);
    }

    //Relación uno a muchos
    public function configpagos(): HasMany
    {
        return $this->hasMany(ConfiguracionPago::class);
    }

    //Relación uno a muchos
    public function ciclos(): HasMany
    {
        return $this->hasMany(Ciclo::class);
    }

    //Relación uno a muchos
    public function planes(): HasMany
    {
        return $this->hasMany(Planes::class);
    }

    //Relación uno a muchos
    public function cobranzas(): HasMany
    {
        return $this->hasMany(Cobranza::class);
    }
}
