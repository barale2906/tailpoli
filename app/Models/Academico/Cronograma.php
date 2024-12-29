<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cronograma extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function grupo() : BelongsTo
    {
        return $this->BelongsTo(Grupo::class);
    }

    //Relacion uno a muchos inversa
    public function ciclo() : BelongsTo
    {
        return $this->BelongsTo(Ciclo::class);
    }

    /**
     * Relación muchos a muchos.
     * detalles del cronograma
     */
    public function cronodetas(): HasMany
    {
        return $this->hasMany(Cronodeta::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){

            $query->wherehas('grupo', function($query) use($item){
                        $query->where('grupos.name', 'like', "%".$item."%");
                    });
        });
    }

    public function scopeProfesor($query, $profesor){
        $query->when($profesor ?? null, function($query, $profesor){
            $query->wherehas('grupo', function($que) use ($profesor){
                    $que->where('grupos.profesor_id', $profesor);
            });
        });
    }
}
