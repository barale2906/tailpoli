<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modulo extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function curso() : BelongsTo
    {
        return $this->BelongsTo(Curso::class);
    }

}
