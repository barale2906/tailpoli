<?php

namespace App\Models\Financiera;

use App\Models\Configuracion\Sede;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ReciboPago extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    //Relacion uno a muchos inversa
    public function creador() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function pagador() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    /**
     * Relación muchos a muchos.
     * Cierres de caja y recibos de pago
     */
    /* public function cierres(): BelongsToMany
    {
        return $this->belongsToMany(CierreCaja::class);
    } */

    /**
     * Relación muchos a muchos.
     * recibos de pago por pagos de cartera
     */
    public function carteras(): BelongsToMany
    {
        return $this->belongsToMany(Cartera::class);
    }

    /**
     * Relación muchos a muchos.
     * recibos de pago por concepto de pago
     */
    public function conceptos(): BelongsToMany
    {
        return $this->belongsToMany(ConceptoPago::class);
    }


}
