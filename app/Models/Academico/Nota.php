<?php

namespace App\Models\Academico;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nota extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    //Relacion uno a muchos inversa
    public function profesor() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function grupo() : BelongsTo
    {
        return $this->BelongsTo(Grupo::class);
    }


}
