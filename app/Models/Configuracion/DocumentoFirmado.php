<?php

namespace App\Models\Configuracion;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentoFirmado extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos
    public function estudiante(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relación uno a muchos
    public function documento(): BelongsTo
    {
        return $this->BelongsTo(Documento::class);
    }

}
