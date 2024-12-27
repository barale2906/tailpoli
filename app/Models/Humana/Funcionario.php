<?php

namespace App\Models\Humana;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcionario extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa
    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    //Relación uno a muchos
    public function funcionarios(): HasMany
    {
        return $this->hasMany(Funcionariosoporte::class);
    }

    //Relación uno a muchos
    public function familiares(): HasMany
    {
        return $this->hasMany(Funcionariofamilia::class);
    }

    //Relación uno a muchos
    public function salarios(): HasMany
    {
        return $this->hasMany(Funcionariosalario::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->wherehas('user', function($query) use($item){
                        $query->where('users.name', 'like', "%".$item."%")
                                ->orwhere('users.documento', 'like', "%".$item."%")
                                ->orwhere('users.email', 'like', "%".$item."%");
                    });
        });
    }


}
