<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class IntervencionesEventoDraft extends Model
{
    use HasFactory;
    protected $table = 'intervenciones_evento_draft';
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
    // Relaciones

        //Relacion con User
        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

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

    public function inventarioMuniciones()
    {
        return $this->hasMany(IntervencionesEventoDraft::class);
    }

    public function evento()
    {
            return $this->belongsTo(Evento::class,);
    }
        public function actualizacionesEvento()
    {
        return $this->morphMany(ActualizacionesReporte::class, 'reportable');
    }






}

