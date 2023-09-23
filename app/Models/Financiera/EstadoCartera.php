<?php

namespace App\Models\Financiera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoCartera extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos
    public function carteras(): HasMany
    {
        return $this->hasMany(Cartera::class);
    }
}
