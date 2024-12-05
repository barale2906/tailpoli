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
        return $this->belongsToMany(ConceptoPago::class, 'concepto_pago_recibo_pago')
                    ->withPivot('valor','tipo','medio','producto','cantidad','unitario','subtotal','id_relacional');
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('numero_recibo', 'like', "%".$item."%")
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

    public function scopeMedio($query, $medio){
        $query->when($medio ?? null, function($query, $medio){
            $query->where('medio', 'like', "%".$medio."%");
        });
    }

    public function scopeCajero($query, $cajero){
        $query->when($cajero ?? null, function($query, $cajero){
            $query->where('creador_id', $cajero);
        });
    }

    public function scopeCrea($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $fecha2->addSeconds(86399);
            $query->whereBetween('fecha', [$fecha1 , $fecha2]);
        });
    }

    public function scopeTransaccion($query, $latrans){
        $query->when($latrans ?? null, function($query, $latrans){
            $fec1=Carbon::parse($latrans[0]);
            $fec2=Carbon::parse($latrans[1]);
            $fec2->addSeconds(86399);

            $query->whereBetween('fecha_transaccion', [$fec1 , $fec2]);
        });
    }

    public function scopeTipo($query, $conpago){
        $query->when($conpago ?? null, function ($qu, $conpago){
            $qu->wherehas('conceptos', function($quer) use($conpago){
                $quer->where('concepto_pago_recibo_pago.concepto_pago_id', $conpago);
            });
        });
    }

}
