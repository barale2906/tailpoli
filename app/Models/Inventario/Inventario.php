<?php

namespace App\Models\Inventario;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventario extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function producto() : BelongsTo
    {
        return $this->BelongsTo(Producto::class);
    }

    //Relacion uno a muchos inversa
    public function almacen() : BelongsTo
    {
        return $this->BelongsTo(Almacen::class);
    }

    //Relacion uno a muchos inversa
    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
