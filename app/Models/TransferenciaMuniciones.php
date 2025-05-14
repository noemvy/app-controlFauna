<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Exception;

class TransferenciaMuniciones extends Model
{
    protected $table = 'transferencias_municiones';

    protected $fillable = [
        'aerodromo_origen_id',
        'aerodromo_destino_id',
        'catinventario_id',
        'cantidad',
        'user_id',
        'observaciones',
    ];

    // Aeródromo de origen
    public function aerodromoOrigen(): BelongsTo
    {
        return $this->belongsTo(Aerodromo::class, 'aerodromo_origen_id');
    }

    // Aeródromo de destino
    public function aerodromoDestino(): BelongsTo
    {
        return $this->belongsTo(Aerodromo::class, 'aerodromo_destino_id');
    }

    // Relación con el catálogo de inventario (munición)
    public function catinventario(): BelongsTo
    {
        return $this->belongsTo(CatalogoInventario::class, 'catinventario_id');
    }

    // Usuario que realizó la transferencia
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // (Opcional) Relación con los movimientos si deseas registrar uno por transferencia
    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'catinventario_id', 'catinventario_id')
            ->where(function ($query) {
                $query->where('aerodromo_id', $this->aerodromo_origen_id)
                    ->orWhere('aerodromo_id', $this->aerodromo_destino_id);
            });
    }



/*--------------------------------------------------------FUNCION DE TRANSFERENCIA ENTRE AEROPUERTOS--------------------------------------------------------------------------------*/
        public static function transferir(array $data): bool
    {
        DB::beginTransaction();

        try {
            $origen = InventarioMuniciones::where('aerodromo_id', $data['aerodromo_origen_id'])
                ->where('catinventario_id', $data['catinventario_id'])
                ->lockForUpdate()
                ->first();

            if (! $origen || $origen->cantidad_actual < $data['cantidad']) {
                throw new Exception('Stock insuficiente en el aeropuerto de origen.');
            }

            $destino = InventarioMuniciones::firstOrCreate(
                [
                    'aerodromo_id' => $data['aerodromo_destino_id'],
                    'catinventario_id' => $data['catinventario_id'],
                ],
                ['cantidad_actual' => 0]
            );

                $origen->decrement('cantidad_actual', $data['cantidad']);
                $destino->increment('cantidad_actual', $data['cantidad']);


                self::create($data);

                DB::commit();
                return true;

            }catch (\Exception $e) {
                DB::rollBack();
                throw $e;
        }
    }
/*--------------------------------------------------------------------------------FUNCION PARA QUE TRANSFERENCIA GUARDE TAMBIEN COMO MOVIMIENTO----------------------------------------------------------*/

    protected static function booted()
    {
        static::created(function ($transferencia) {
            // Registrar movimiento de salida para que guarde como tipo de movimiento de transferencia en la tabla movimiento
            MovimientoInventario::create([
                'aerodromo_id' => $transferencia->aerodromo_origen_id,
                'catinventario_id' => $transferencia->catinventario_id,
                'tipo_movimiento' => 'transferencia',
                'user_id' => $transferencia->user_id,
                'cantidad_usar' => 0,
                'comentarios' => 'Transferencia hacia aeropuerto ID: ' . $transferencia->aerodromo_destino_id,
            ]);

            // Registrar movimiento de entrada para que guarde como tipo de movimiento de transferencia en la tabla movimiento y cuente como movimiento de entrada en
            //el aeropuerto de origen
            MovimientoInventario::create([
                'aerodromo_id' => $transferencia->aerodromo_destino_id,
                'catinventario_id' => $transferencia->catinventario_id,
                'tipo_movimiento' => 'transferencia',
                'user_id' => $transferencia->user_id,
                'cantidad_usar' => 0,
                'comentarios' => 'Transferencia desde aeropuerto ID: ' . $transferencia->aerodromo_origen_id,
            ]);

        });



    }
}


