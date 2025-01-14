<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Acaplandeta extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function acaplan() : BelongsTo
    {
        return $this->BelongsTo(Acaplan::class);
    }

    //Relacion uno a muchos inversa
    public function tema() : BelongsTo
    {
        return $this->BelongsTo(Unidtema::class);
    }


}
