<?php

namespace App\Models\Configuracion;

use App\Models\Academico\Matricula;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Docugrado extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos
    public function matricula(): BelongsTo
    {
        return $this->BelongsTo(Matricula::class);
    }

    public function graduando(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

}
