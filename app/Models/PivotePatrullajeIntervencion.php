<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotePatrullajeIntervencion extends Model
{
    use HasFactory;

    protected $table = 'pivote_patrullaje_intervenciones';
    protected $fillable = [
        'intervencion_draft_id',
        'intervencion_id',
        'catinventario_id',
        'acciones_id',
        'cantidad_utilizada',
    ];

    public function intervencionesDraft()
    {
        return $this->belongsTo(IntervencionesDraft::class);
    }
    public function intervencion()
    {
        return $this->belongsTo(Intervenciones::class, 'intervenciones_id');
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
