<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable =['name', 'status'];

    //Relación uno a muchos
    public function sectors(): HasMany
    {
        return $this->hasMany(Sector::class);
    }
}
