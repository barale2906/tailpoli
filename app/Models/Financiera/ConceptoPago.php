<?php

namespace App\Models\Financiera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConceptoPago extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a muchos.
     * recibos de pago por concepto de pago
     */
    public function recibos(): BelongsToMany
    {
        return $this->belongsToMany(ReciboPago::class, 'concepto_pago_recibo_pago')
                    ->withPivot('valor','tipo','medio','producto','cantidad','unitario','subtotal','id_relacional');
    }

    public function carteras():HasMany
    {
        return $this->hasMany(Cartera::class);
    }

    public function otros():HasMany
    {
        return $this->hasMany(ConfPagOtrosDet::class);
    }

}
