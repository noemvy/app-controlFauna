<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloAeronave extends Model
{
    use HasFactory;

    protected $table = 'modelo_aeronaves';

    protected $fillable = [
        'modelo',
        'fabricante_id',
        'estado',
    ];

    public function fabricante()
    {
        return $this->belongsTo(FabricanteAeronave::class, 'fabricante_id');
    }
}
