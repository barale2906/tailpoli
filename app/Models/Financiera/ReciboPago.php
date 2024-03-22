<?php

namespace App\Models\Financiera;

use App\Models\Configuracion\Sede;
use App\Models\User;
use Carbon\Carbon;
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
    public function paga() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    /**
     * Relación muchos a muchos.
     * Cierres de caja y recibos de pago
     */
    public function cierres(): BelongsToMany
    {
        return $this->belongsToMany(CierreCaja::class);
    }


    /**
     * Relación muchos a muchos.
     * recibos de pago por concepto de pago
     */
    public function conceptos(): BelongsToMany
    {
        return $this->belongsToMany(ConceptoPago::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('numero_recibo', 'like', "%".$item."%")
                    ->orwhere('medio', 'like', "%".$item."%")
                    ->orwhere('observaciones', 'like', "%".$item."%")

                    ->orwherehas('creador', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%");
                    })

                    ->orwherehas('paga', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%")
                            ->orwhere('users.documento', 'like', "%".$item."%");
                    })

                    ->orwherehas('conceptos', function($query) use($item){
                        $query->where('concepto_pagos.name', 'like', "%".$item."%");
                    });
        });
    }

    public function scopeSede($query, $sede){
        $query->when($sede ?? null, function($query, $sede){
            $query->where('sede_id', $sede);
        });
    }

    public function scopeCrea($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $query->whereBetween('fecha', [$fecha1 , $fecha2]);
        });
    }

}
