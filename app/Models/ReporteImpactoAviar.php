<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteImpactoAviar extends Model
{


    protected $table = 'reporte_impactoaviar';

    protected $fillable = [
        'codigo',
        'aerodromo_id',
        'pista_id',
        'fecha',
        'aerolinea_id',
        'modelo_id',
        'matricula',
        'Altitud',
        'Velocidad',
        'Luminosidad',
        'Fase_vuelo',
        'cielo',
        'temperatura',
        'viento_velocidad',
        'viento_direccion',
        'condicion_visual',
        'especie_id',
        'fauna_observada',
        'fauna_impactada',
        'fauna_tamano',
        'consecuencia',
        'observacion',
        'tiempo_fs',
        'costo_reparacion',
        'costo_otros',
        'estado',
    ];
    //Relaciones

    public function aerodromo()
    {
        return $this->belongsTo(Aerodromo::class);
    }

    public function pista()
    {
        return $this->belongsTo(Pista::class);
    }

    public function aerolinea()
    {
        return $this->belongsTo(Aerolinea::class);
    }

    public function modelo()
    {
        return $this->belongsTo(ModeloAeronave::class);
    }

    public function Especie()
    {
        return $this->belongsTo(Especie::class);
    }

    public function partesGolpeadas()
    {
        return $this->belongsToMany(PiezaAvion::class, 'partes_golpeadas', 'reporte_id', 'pieza_id')->withTimestamps();
    }

    public function partesDanadas()
    {
        return $this->belongsToMany(PiezaAvion::class, 'partes_danadas', 'reporte_id', 'pieza_id')->withTimestamps();
    }

    // public function actualizaciones()
    // {
    //     return $this->morphMany(ActualizacionesReporte::class, 'reportable');
    // }
}
