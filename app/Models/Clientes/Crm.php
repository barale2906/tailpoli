<?php

namespace App\Models\Clientes;

use App\Models\Configuracion\Sector;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Crm extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function sector() : BelongsTo
    {
        return $this->BelongsTo(Sector::class);
    }

    //Relacion uno a muchos inversa
    public function gestiona() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
