<?php

/*-------------------------------------------INTERVENCIONES DE PATRULLAJE-------------------------------------------------- */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervenciones extends Model
{
    protected $table = 'intervenciones';

    protected $fillable = [
        'especies_id',
        'atractivos_id',
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

    public function pivote()
{
    return $this->hasMany(\App\Models\PivotePatrullajeIntervencion::class, 'intervencion_id');
}

}





