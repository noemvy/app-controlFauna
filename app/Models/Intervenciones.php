<?php

/*-------------------------------------------INTERVENCIONES DE PATRULLAJE-------------------------------------------------- */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervenciones extends Model
{
    protected $table = 'intervenciones';

    protected $fillable = [
        'especies_id',
        'catinventario_id',
        'acciones_id',
        'atractivos_id',
        'cantidad_utilizada',
        'guardado',
        'vistos',
        'sacrificados',
        'dispersados',
        'coordenada_x',
        'coordenada_y',
        'fotos',
        'temperatura',
        'viento',
        'humedad',
        'comentarios',
        'patrullaje_id'
    ];

    protected $casts = [
        'fotos' => 'array',
        'municion_utilizada' => 'array', /*Uso de esto para capturar los datos del repeater en el resource de IntervencionesDraft */
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

    //Relacion con patrullaje
    public function patrullaje()
    {
        return $this->belongsTo(Patrullaje::class);
    }


}





