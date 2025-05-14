<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    use HasFactory;
    protected $fillable = ['grupo_id', 'nombre', 'nombre_comun', 'foto'];


    //Relacion con el Grupo al que pertenece la especie
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupos_id');
    }

    //
}
