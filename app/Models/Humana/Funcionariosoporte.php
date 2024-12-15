<?php

namespace App\Models\Humana;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Funcionariosoporte extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function funcion() : BelongsTo
    {
        return $this->BelongsTo(Funcionario::class);
    }

    //Relacion uno a muchos inversa
    public function usuario() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
