<?php

namespace App\Models\Inventario;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Inventario extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function producto() : BelongsTo
    {
        return $this->BelongsTo(Producto::class);
    }

    //Relacion uno a muchos inversa
    public function almacen() : BelongsTo
    {
        return $this->BelongsTo(Almacen::class);
    }

    //Relacion uno a muchos inversa
    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){

            $query->where('descripcion', 'like', "%".$item."%")
                    ->orwhere('fecha_movimiento', 'like', "%".$item."%")
                    ->orWhereHas('producto', function($q) use($item){
                        $q->where('name', 'like', "%".$item."%");
                    })
                    ->orWhereHas('almacen', function($qu) use($item){
                        $qu->where('name', 'like', "%".$item."%");
                    })
                    ->orWhereHas('user', function($que) use($item){
                        $que->where('name', 'like', "%".$item."%");
                    });
        });
    }

    public function scopeCrea($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $fecha2->addSeconds(86399);
            $query->whereBetween('fecha_movimiento', [$fecha1 , $fecha2]);
        });
    }

    public function scopeTipo($query, $tipo){
        $query->when($tipo ?? null, function($query, $tipo){
            $query->where('tipo', $tipo);
        });
    }

    public function scopeAlmacen($query, $almacen){
        $query->when($almacen ?? null, function($query, $almacen){
            $query->where('almacen_id', $almacen);
        });
    }

    public function scopeSaldo($query, $saldo){
        $query->when($saldo ?? null, function($query, $saldo){
            $query->where('status', true)
                    ->where('saldo', '>', 0)
                    ->whereIn('tipo', [0,1]);
        });
    }

}
