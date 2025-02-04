<?php

namespace App\Models\Academico;

use App\Models\Configuracion\Sede;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

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

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->wherehas('estudiante', function($query) use($item){
                $query->where('users.name', 'like', "%".$item."%")
                        ->orwhere('users.documento', 'like', "%".$item."%");
            });
        });
    }

    public function scopeProfesor($query, $profe){
        $query->when($profe ?? null, function($query, $profe){
            $query->wherehas('ciclo', function($query) use($profe){
                        $query->wherehas('ciclogrupos', function($query) use($profe){
                            $query->wherehas('grupo', function($query) use($profe){
                                $query->where('grupos.profesor_id', intval($profe));
                            });
                        });
                    });
        });
    }

    public function scopeEstado($query,$item){
        $query->when($item ?? null, function($query) use($item){
            $query->where('status_est', $item);
        });
    }

    public function scopeSede($query, $sede){
        $query->when($sede ?? null, function($query, $sede){
            $query->where('sede_id', intval($sede));
        });
    }

    public function scopeCurso($query, $curso){
        $query->when($curso ?? null, function($query, $curso){
            $query->wherehas('matricula', function($qu) use($curso){
                $qu->where('matriculas.curso_id', intval($curso));
            });
        });
    }

    public function scopeInicia($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $query->whereBetween('inicia', [$fecha1 , $fecha2]);
        });
    }

    public function scopeStatus($query, $status){
        $query->when($status ?? null, function($query, $status){
            $query->whereIn('status_est', $status);
        });
    }

    public function scopeCiclo($query, $ciclo){
        $query->when($ciclo ?? null, function($query, $ciclo){
            $query->where('ciclo_id', $ciclo);
        });
    }

    public function scopeGrado($query, $grado){
        $query->when($grado ?? null, function($query, $grado){
            $fecha1=Carbon::parse($grado[0]);
            $fecha2=Carbon::parse($grado[1]);
            $query->whereBetween('fecha_grado', [$fecha1 , $fecha2]);
        });
    }

    public function scopeEstudiantes($query, $estudiantes){
        $query->when($estudiantes ?? null, function($query, $estudiantes){
            $query->whereIn('estudiante_id', $estudiantes);
        });
    }

    public function scopeDesert($query, $deser){
        $query->when($deser ?? null, function($query, $deser){
            $query->where('ultima_asistencia', $deser);
        });
    }
}

