<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PersonaMulticultural extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a muchos.
     * Perfiles con Multicultural
     */
    public function perfiles(): BelongsToMany
    {
        return $this->belongsToMany(Perfil::class);
    }
}
