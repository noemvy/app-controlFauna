<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntervencionesEvento extends Model
{
    protected $table = 'intervenciones_evento';

    protected $fillable = [
        'user_id',
        'tipo_evento',
        'origen',
        'estado',
        'coordenada_x',
        'coordenada_y',
        'temperatura',
        'viento',
        'humedad',
        'especies_id',
        'atractivos_id',
        'vistos',
        'sacrificados',
        'dispersados',
        'fotos',
        'comentarios',
        'municion_utilizada',
        'catinventario_id',
        'acciones_id',
        'cantidad_utilizada',
    ];
    protected $casts = [
        'coordenada_x' => 'decimal:6',
        'coordenada_y' => 'decimal:6',
        'temperatura' => 'float',
        'viento' => 'float',
        'humedad' => 'float',
        'fotos' => 'array',
        'municion_utilizada' => 'array',
    ];
    // Relación con Especie
    public function especie()
    {
        return $this->belongsTo(Especie::class, 'especies_id');
    }

    // Relación con Catálogo de Inventario
    public function catalogoInventario()
    {
        return $this->belongsTo(CatalogoInventario::class, 'catinventario_id');
    }

    // Relación con Acciones
    public function accion()
    {
        return $this->belongsTo(Acciones::class, 'acciones_id');
    }

    // Relación con Atractivos
    public function atractivo()
    {
        return $this->belongsTo(Atractivo::class, 'atractivos_id');
    }

    // Relación polimórfica con cualquier reporte (evento, patrullaje, etc.)
    public function reportable()
    {
        return $this->morphTo();
    }
    public function evento()
    {
        return $this->belongsTo(Patrullaje::class);
    }

}
