<?php

namespace App\Models\Financiera;

use App\Models\Academico\Curso;
use App\Models\Configuracion\Sector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfiguracionPago extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function sector() : BelongsTo
    {
        return $this->BelongsTo(Sector::class);
    }

    //Relacion uno a muchos inversa
    public function curso() : BelongsTo
    {
        return $this->BelongsTo(Curso::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('descripcion', 'like', "%".$item."%")

                    ->orWhereHas('sector', function($q) use($item){
                        $q->where('sectors.name', 'like', "%".$this->buscamin."%");
                    });
        });
    }

    public function scopeCurso($query, $curso){
        $query->when($curso ?? null, function($query, $curso){
            $query->where('curso_id', $curso);
        });
    }
}
