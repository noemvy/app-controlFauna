<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParteGolpeada extends Model
{
    use HasFactory;

    protected $table = 'partes_golpeadas';

    protected $fillable = [
        'reporte_id',
        'pieza_id',
    ];

    //Relacion con Reporte Impacto Aviar
    public function reporte()
    {
        return $this->belongsTo(ReporteImpactoAviar::class, 'reporte_id');
    }

    //Relacion Pieza Avion
    public function pieza()
    {
        return $this->belongsTo(PiezaAvion::class, 'pieza_id');
    }

    //Relacion con parte Golpeadas
    public function partesGolpeadas()
    {
        return $this->hasMany(ParteGolpeada::class, 'reporte_id');
    }
}
