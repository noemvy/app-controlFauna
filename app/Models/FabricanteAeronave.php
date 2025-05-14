<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricanteAeronave extends Model
{
    use HasFactory;
    protected $table ='fabricante_aeronave';
    protected $fillable= [
        'nombre',
        'estado',
    ];

    public function modelos()
    {
        return $this->hasMany(ModeloAeronave::class, 'fabricante_id');
    }
}
