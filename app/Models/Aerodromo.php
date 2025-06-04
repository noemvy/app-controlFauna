<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aerodromo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'codigo', 'descripcion', 'autor', 'estado'];

    //Relacion con Pistas
    public function pistas()
    {
        return $this->hasMany(Pista::class);
    }

    //Relacion con Destinatarios
    public function destinatarios()
    {
        return $this->belongsToMany(Destinatario::class, 'destinatario_aerodromo');
    }

    //Relacion con Users
    public function users()
    {
        return $this->hasMany(User::class);
    }
/*----------------------------------------------------------------------------------------------------------------*/
        //RELACIONES NUEVAS


        //Relacion con el inventario de municiones
        public function inventarioMuniciones()
    {
        return $this->hasMany(InventarioMuniciones::class, 'aerodromo_id');
    }

    //Relación Movimiento Inventario
    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class, 'aerodromo_id');
    }

        //Relacion con Patrullajes
    public function patrullajes()
    {
        return $this->hasMany(Patrullaje::class, 'aerodromo_id');
    }
        //Relacion con Eventos

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'aerodromo_id');
    }
    public function transferencias()
    {
        return $this->hasMany(TransferenciaMuniciones::class, 'aerodromo_id');
    }



}
