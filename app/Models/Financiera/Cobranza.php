<?php

namespace App\Models\Financiera;

use App\Models\Academico\Curso;
use App\Models\Academico\Matricula;
use App\Models\Configuracion\Sede;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cobranza extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function cobracorres():HasMany
    {
        return $this->hasMany(Cobranzarchivo::class);
    }

    //Relacion uno a muchos inversa
    public function cartera() : BelongsTo
    {
        return $this->BelongsTo(Cartera::class);
    }

    //Relacion uno a muchos inversa
    public function alumno() : BelongsTo
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

    //Relacion uno a muchos inversa
    public function curso() : BelongsTo
    {
        return $this->BelongsTo(Curso::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->wherehas('alumno', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%")
                                ->orwhere('users.documento', 'like', "%".$item."%");
                    });
        });
    }

    public function scopeSede($query, $sede){
        $query->when($sede ?? null, function($query, $sede){
            $query->where('sede_id', intval($sede));
        });
    }

    public function scopeCurso($query, $curso){
        $query->when($curso ?? null, function($query, $curso){
            $query->where('curso_id', intval($curso));
        });
    }

    public function scopeEtapa($query, $etapa){
        $query->when($etapa ?? null, function($query, $etapa){
            $query->where('etapa', intval($etapa));
        });
    }
}
