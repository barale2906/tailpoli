<?php

namespace App\Models\Financiera;

use App\Models\Academico\Matricula;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Cartera extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function matricula() : BelongsTo
    {
        return $this->BelongsTo(Matricula::class);
    }

    //Relacion uno a muchos inversa
    public function estadoCartera() : BelongsTo
    {
        return $this->BelongsTo(EstadoCartera::class);
    }

    //Relacion uno a muchos inversa
    public function responsable(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function concepto_pago(): BelongsTo
    {
        return $this->BelongsTo(ConceptoPago::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('concepto', 'like', "%".$item."%")

                    ->orwherehas('responsable', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%");
                    })

                    ->orwherehas('concepto_pago', function($query) use($item){
                        $query->where('concepto_pagos.name', 'like', "%".$item."%");
                    })

                    ->orwherehas('estadoCartera', function($query) use($item){
                        $query->where('estado_carteras.name', 'like', "%".$item."%");
                    });
        });
    }
    public function scopeVencido($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $fecha2->addSeconds(86399);
            $query->whereBetween('fecha_pago', [$fecha1 , $fecha2]);
        });
    }

}
