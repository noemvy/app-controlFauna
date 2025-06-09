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
        'advertencia',
        'especies_id',
        'fauna_observada',
        'fauna_impactada',
        'fauna_tamano',
        'img_paths_fauna',
        'img_paths_impacto',
        'consecuencia',
        'observacion',
        'tiempo_fs',
        'costo_reparacion',
        'costo_otros',
        'estado',
        'cargo',
        'user_id'
    ];
    protected $casts =[
    'img_paths_fauna' => 'array',
    'img_paths_impacto' => 'array',
    'advertencia' => 'array',
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

    public function especie()
    {
        return $this->belongsTo(Especie::class,'especies_id');
    }

    public function partesGolpeadas()
    {
        return $this->belongsToMany(PiezaAvion::class, 'partes_golpeadas', 'reporte_id', 'pieza_id')->withTimestamps();
    }

    public function partesDanadas()
    {
        return $this->belongsToMany(PiezaAvion::class, 'partes_danadas', 'reporte_id', 'pieza_id')->withTimestamps();
    }

    public function actualizaciones()
    {
        return $this->morphMany(ActualizacionesReporte::class, 'reportable');
    }

        public function user()
    {
        return $this->belongsTo(User::class); //autor);
    }


    //FUNCIONES PARA AGREGARLO CODIGO A LOS FORMULARIOS
    protected static function booted()
    {
        parent::boot();

        static::creating(function ($reporte) {
            $ultimoId = static::max('id') + 1; // Obtiene el próximo ID
            $reporte->codigo = 'IFA-' . str_pad($ultimoId, 4, '0', STR_PAD_LEFT); // Genera el código único
        });
    }
}
