<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pista extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'codigo', 'descripcion', 'autor', 'estado', 'aerodromo_id'];

    //Relacion con Aerodromos
    public function aerodromo()
    {
        return $this->belongsTo(Aerodromo::class);
    }
}
