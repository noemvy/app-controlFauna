<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destinatario extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'correo', 'tipo', 'formulario', 'autor', 'estado'];


    //Relacion con Aerodromos
    public function aerodromos()
    {
        return $this->belongsToMany(Aerodromo::class, 'destinatario_aerodromo');
    }
}
