<?php

namespace App\Models\Financiera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConceptoPago extends Model
{
    use HasFactory;

    protected $fillable =['name', 'status'];

    /**
     * Relación muchos a muchos.
     * recibos de pago por concepto de pago
     */
    public function recibos(): BelongsToMany
    {
        return $this->belongsToMany(ReciboPago::class);
    }

    public function carteras():HasMany
    {
        return $this->hasMany(Cartera::class);
    }

}
