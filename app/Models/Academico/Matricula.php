<?php

namespace App\Models\Academico;

use App\Models\Configuracion\Docugrado;
use App\Models\Configuracion\Documento;
use App\Models\Configuracion\DocumentoFirmado;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cobranza;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matricula extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    //Relacion uno a muchos inversa
    public function creador() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function alumno() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function comercial() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relacion uno a muchos inversa
    public function curso() : BelongsTo
    {
        return $this->BelongsTo(Curso::class);
    }

    //Relacion uno a muchos inversa
    public function sede() : BelongsTo
    {
        return $this->BelongsTo(Sede::class);
    }

    //Relacion muchos a muchos
    public function grupos() : BelongsToMany
    {
        return $this->BelongsToMany(Grupo::class);
    }

    //Relación uno a muchos
    public function documentos(): BelongsToMany
    {
        return $this->BelongsToMany(Documento::class);
    }

    //Relación uno a muchos
    public function firmados(): HasMany
    {
        return $this->hasMany(DocumentoFirmado::class);
    }

    //Relación uno a muchos
    public function cobranzas(): HasMany
    {
        return $this->hasMany(Cobranza::class);
    }

    //Relación uno a muchos
    public function control(): HasMany
    {
        return $this->hasMany(Control::class);
    }

    public function docugrados(): HasMany
    {
        return $this->hasMany(Docugrado::class);
    }


    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->orwherehas('alumno', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%")
                                ->orwhere('users.documento', 'like', "%".$item."%");
                    })

                    ->orwherehas('grupos', function($query) use($item){
                        $query->where('grupos.name', 'like', "%".$item."%");
                    })

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

    public function scopeSedecurso($query, $sedec){
        $query->when($sedec ?? null, function($query, $sedec){
            $query->wherehas('control', function($query) use($sedec){
                $query->where('controls.sede_id', $sedec);

            });
        });
    }

    public function scopeCurso($query, $curso){
        $query->when($curso ?? null, function($query, $curso){
            $query->where('curso_id', $curso);
        });
    }

    public function scopeCreador($query, $creador){
        $query->when($creador ?? null, function($query, $creador){
            $query->where('creador_id', $creador);
        });
    }

    public function scopeComercial($query, $comercial){
        $query->when($comercial ?? null, function($query, $comercial){
            $query->where('comercial_id', $comercial);
        });
    }

    public function scopeStatus($query, $status){
        $query->when($status ?? null, function($query, $status){

            if($status===2){
                $crt=0;
            }
            if($status===3){
                $crt=1;
            }
            $query->where('status', $crt);
        });
    }

    public function scopeCrea($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $fecha2->addSeconds(86399);
            $query->whereBetween('created_at', [$fecha1 , $fecha2]);
        });
    }

    public function scopeInicia($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $query->whereBetween('fecha_inicia', [$fecha1 , $fecha2]);
        });
    }

    public function scopeStatusest($query, $statusest){
        $query->when($statusest ?? null, function($query, $statusest){
            $query->whereIn('status_est', $statusest);
        });
    }

}
