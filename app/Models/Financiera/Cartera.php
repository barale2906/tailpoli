<?php

namespace App\Models\Financiera;

use App\Models\Academico\Matricula;
use App\Models\Configuracion\Sector;
use App\Models\Configuracion\Sede;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    //Relacion uno a muchos inversa
    public function sector() : BelongsTo
    {
        return $this->BelongsTo(Sector::class);
    }

    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    public function cobranzas():HasMany
    {
        return $this->hasMany(Cobranza::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('concepto', 'like', "%".$item."%")

                    ->orwherehas('responsable', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%")
                                ->orwhere('users.documento', 'like', "%".$item."%");
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

    public function scopeSede($query, $sede){
        $query->when($sede ?? null, function($query, $sede){
            $query->where('sede_id', $sede);
        });
    }

    public function scopeCiudad($query, $ciudad){
        $query->when($ciudad ?? null, function($query, $ciudad){
            $query->where('sector_id', $ciudad);
        });
    }

    public function scopeStatus($query, $status){
        $query->when($status ?? null, function($query, $status){
            $query->whereIn('status_est', $status);
        });
    }

    public function scopeStatcar($query, $stat){
        $query->when($stat ?? null, function($query, $stat){
            $query->whereIn('estado_cartera_id', $stat);
        });
    }

}
