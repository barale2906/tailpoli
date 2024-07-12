<?php

namespace App\Models\Financiera;

use App\Models\Academico\Control;
use App\Models\Configuracion\Sede;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Transaccion extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function creador() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function gestionador() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa alumno
    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('fecha', 'like', "%".$item."%")
                    ->orwhere('observaciones', 'like', "%".$item."%")
                    ->orwhere('id', 'like', "%".$item."%")

                    ->orwherehas('creador', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%");
                    })

                    ->orwherehas('gestionador', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%");
                    })

                    ->orwherehas('user', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%");
                    })

                    ->orwherehas('sede', function($query) use($item){
                        $query->where('sedes.name', 'like', "%".$item."%");
                    });
        });
    }

    public function scopeEstado($query, $estado){
        $query->when($estado ?? null, function($query, $estado){
            $query->where('status', $estado);
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
