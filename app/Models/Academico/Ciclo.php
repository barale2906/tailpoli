<?php

namespace App\Models\Academico;

use App\Models\Configuracion\Sede;
use App\Models\Academico\Asistencia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ciclo extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    //Relacion uno a muchos inversa
    public function curso() : BelongsTo
    {
        return $this->BelongsTo(Curso::class);
    }

    //Relacion uno a muchos inversa
    public function creador() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relación uno a muchos
    public function control(): HasOne
    {
        return $this->hasOne(Control::class);
    }

    //Relación uno a muchos
    public function ciclogrupos(): HasMany
    {
        return $this->hasMany(Ciclogrupo::class);
    }

    //Relación uno a muchos
    public function cicloasistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('name', 'like', "%".$item."%")

                    ->orwherehas('curso', function($query) use($item){
                        $query->where('cursos.name', 'like', "%".$item."%");
                    });
        });
    }

    public function scopeSede($query, $sede){
        $query->when($sede ?? null, function($query, $sede){
            $query->where('sede_id', $sede);
        });
    }

    public function scopeCurso($query, $curso){
        $query->when($curso ?? null, function($query, $curso){
            $query->where('curso_id', $curso);
        });
    }

    public function scopeInicia($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $query->whereBetween('inicia', [$fecha1 , $fecha2]);
        });
    }
}
