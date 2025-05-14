<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiezaAvion extends Model
{
    use HasFactory;

    protected $table = 'pieza_avion';

    protected $fillable = [
        'nombre',
        'estado',
    ];
}
