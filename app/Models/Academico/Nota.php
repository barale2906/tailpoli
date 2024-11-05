<?php

namespace App\Models\Academico;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nota extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    //Relacion uno a muchos inversa
    public function profesor() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function grupo() : BelongsTo
    {
        return $this->BelongsTo(Grupo::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('descripcion', 'like', "%".$item."%")
                    ->orWhereHas('grupo', function($q) use($item) {
                        $q->where('name', 'like', "%".$item."%");
                    })
                    ->orWhereHas('profesor', function($qu) use($item){
                        $qu->where('name', 'like', "%".$item."%");
                    });
        });
    }

    public function scopeProfesor($query, $profesor){
        $query->when($profesor ?? null, function($query, $profesor){
            $query->where('profesor_id', $profesor);
        });
    }

    public function scopeJornada($query, $jornada){
        $query->when($jornada ?? null, function($query, $jornada){
            $query->WhereHas('grupo', function($qu) use($jornada){
                $qu->where('jornada', $jornada);
            });
        });
    }


}
