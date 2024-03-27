<?php

namespace App\Models\Academico;

use App\Models\Configuracion\Sede;
use App\Models\Financiera\Transaccion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Control extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function ciclo() : BelongsTo
    {
        return $this->BelongsTo(Ciclo::class);
    }

    //Relacion uno a muchos inversa
    public function estudiante() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function matricula() : BelongsTo
    {
        return $this->BelongsTo(Matricula::class);
    }

    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    //Relación uno a muchos
    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('observaciones', 'like', "%".$item."%")

                    ->orwherehas('estudiante', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%")
                                ->orwhere('users.documento', 'like', "%".$item."%");
                    })

                    ->orwherehas('ciclo', function($query) use($item){
                        $query->where('ciclos.name', 'like', "%".$item."%");
                    });
        });
    }
}
