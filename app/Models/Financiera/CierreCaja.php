<?php

namespace App\Models\Financiera;

use App\Models\Configuracion\Sede;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CierreCaja extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a muchos.
     * Cierres de caja y recibos de pago
     */
    public function recibos(): BelongsToMany
    {
        return $this->belongsToMany(ReciboPago::class);
    }

    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    //Relacion uno a muchos inversa
    public function cajero() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function coorcaja() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('observaciones', 'like', "%".$item."%")

                    ->orwherehas('cajero', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%");
                    })

                    ->orwherehas('sede', function($query) use($item){
                        $query->where('sedes.name', 'like', "%".$item."%");
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
