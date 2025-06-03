<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MovimientoInventario extends Model
{
    protected $fillable = [
        'aerodromo_id',
        'catinventario_id',
        'user_id',
        'tipo_movimiento',
        'cantidad_usar',
        'comentario',
        'transferencia_id'
    ];

    protected $table = 'movimiento_inventario';

    /*------------------ RELACIONES ------------------*/
    public function aerodromo()
    {
        return $this->belongsTo(Aerodromo::class, 'aerodromo_id');
    }

    public function catalogoInventario()
    {
        return $this->belongsTo(CatalogoInventario::class, 'catinventario_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function transferencia()
{
    return $this->belongsTo(TransferenciaMuniciones::class, 'transferencia_id');
}





    /*------------------ METODO PARA REGISTRAR MOVIMIENTO ------------------*/
    protected static function booted()
    {
        static::creating(function ($movimiento) {
        if ($movimiento->tipo_movimiento !== 'Transferencia') {
        self::ajustarInventario($movimiento);
        }
});

    }
    protected static function ajustarInventario($movimiento)
    {
        $inventario = InventarioMuniciones::where('aerodromo_id', $movimiento->aerodromo_id)
            ->where('catinventario_id', $movimiento->catinventario_id)
            ->first();

        $tiposEntrada = ['Compra'];

        if (in_array($movimiento->tipo_movimiento, $tiposEntrada)) {

            $inventario->cantidad_actual += $movimiento->cantidad_usar;
        } else {

            if ($inventario->cantidad_actual < $movimiento->cantidad_usar) {
                throw new \Exception("No hay stock suficiente para realizar esta salida.");
            }

            $inventario->cantidad_actual -= $movimiento->cantidad_usar;
        }

        $inventario->save();
    }
}
