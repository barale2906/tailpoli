<?php

namespace App\Models\Financiera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfPagOtrosDet extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function concepto():BelongsTo
    {
        return $this->belongsTo(ConceptoPago::class);
    }

    public function otros():BelongsTo
    {
        return $this->belongsTo(ConfPagOtros::class);
    }
}
