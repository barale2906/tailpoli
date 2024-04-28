<?php

namespace App\Models\Configuracion;

use App\Models\Academico\Matricula;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Documento extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos
    public function matriculas(): BelongsToMany
    {
        return $this->BelongsToMany(Matricula::class);
    }

    //Relación uno a muchos
    public function firmados(): HasMany
    {
        return $this->hasMany(DocumentoFirmado::class);
    }
}
