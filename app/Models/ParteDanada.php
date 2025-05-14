<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParteDanada extends Model
{
    use HasFactory;

    protected $table = 'partes_danadas';

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

    //Relacion Partes Dañadas
    public function partesDanadas()
    {
        return $this->hasMany(ParteDanada::class, 'reporte_id');
    }

}
