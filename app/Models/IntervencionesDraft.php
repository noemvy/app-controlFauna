<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntervencionesDraft extends Model
{
    use HasFactory;

    protected $table = 'intervenciones_drafts';

    protected $fillable = [
        'user_id',
        'especies_id',
        'atractivos_id',
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
        'guardado' => 'boolean',
        'fotos' => 'array',
        'coordenada_x' => 'decimal:6',
        'coordenada_y' => 'decimal:6',
        'temperatura' => 'float',
        'viento' => 'float',
        'humedad' => 'float',


    ];

    // Relaciones
    public function especie()
    {
        return $this->belongsTo(Especie::class, 'especies_id');
    }

    public function catalogoInventario()
    {
        return $this->belongsTo(CatalogoInventario::class, 'catinventario_id');
    }

    public function accion()
    {
        return $this->belongsTo(Acciones::class, 'acciones_id');
    }

    public function atractivo()
    {
        return $this->belongsTo(Atractivo::class, 'atractivos_id');
    }

public function pivote()
{
    return $this->hasMany(PivotePatrullajeIntervencion::class, 'intervencion_draft_id');
}



public function patrullaje()
    {
        return $this->belongsTo(Patrullaje::class,);
    }





}

