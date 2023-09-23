<?php

namespace App\Models\Financiera;

use App\Models\Academico\Matricula;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Cartera extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function matricula() : BelongsTo
    {
        return $this->BelongsTo(Matricula::class);
    }

    //Relacion uno a muchos inversa
    public function estadoCartera() : BelongsTo
    {
        return $this->BelongsTo(EstadoCartera::class);
    }

    //Relacion uno a muchos inversa
    public function responsable(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    /**
     * Relación muchos a muchos.
     * recibos de pago por pagos de cartera
     */
    public function recibos(): BelongsToMany
    {
        return $this->belongsToMany(ReciboPago::class);
    }
}
