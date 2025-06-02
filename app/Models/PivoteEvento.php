<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class PivoteEvento extends Model
{
    use HasFactory;
    protected $table = 'pivote_eventos';
    protected $fillable = [
        'intervencion_id',
        'catinventario_id',
        'acciones_id',
        'cantidad_utilizada',
    ];

    public function intervencionesEventoDraft()
    {
        return $this->belongsTo(IntervencionesEventoDraft::class,'intervencion_id' );
    }
    public function catalogoInventario()
    {
        return $this->belongsTo(CatalogoInventario::class, 'catinventario_id');
    }

    public function acciones()
    {
        return $this->belongsTo(Acciones::class, 'acciones_id');
    }
}
