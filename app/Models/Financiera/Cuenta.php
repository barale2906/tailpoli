<?php

namespace App\Models\Financiera;

use App\Models\Configuracion\Sede;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cuenta extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos inversa
    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }
}
