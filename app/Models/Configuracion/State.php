<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends Model
{
    use HasFactory;

    protected $fillable =['name', 'status'];

    //Relacion uno a muchos inversa
    public function country() : BelongsTo
    {
        return $this->BelongsTo(Country::class);
    }
}
