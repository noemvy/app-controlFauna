<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aerolinea extends Model
{
    protected $table = 'aerolineas';

    protected $fillable = [
        'iata',
        'nombre',
        'tipo',
        'estado',
    ];
}
