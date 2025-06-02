<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioMuniciones extends Model
{
    protected $fillable = [ 'catinventario_id',
        'aerodromo_id',
        'cantidad_actual',
        'cantidad_minima',

    ];
    /*---------------------------------------------RELACIONES CON OTROS MODELOS--------------------------------------------------*/
    //Relacion con Aerodromo
        public function aerodromo()
    {
        return $this->belongsTo(Aerodromo::class, 'aerodromo_id');
    }

    //Relacion con Catalogo Inventario
        public function catalogoInventario()
    {
        return $this->belongsTo(CatalogoInventario::class, 'catinventario_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

}
// Relacion con InventarioMuniciones
public function movimientos()
{
    return $this->hasMany(MovimientoInventario::class, 'catinventario_id', 'catinventario_id')
        ->where('aerodromo_id', $this->aerodromo_id);
}


 /**
     * Relación con intervenciones que han utilizado esta munición.
     */
    public function intervenciones()
    {
        return $this->hasMany(Intervenciones::class, 'inventario_municiones_id');
    }

}
