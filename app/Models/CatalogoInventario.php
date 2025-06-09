<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogoInventario extends Model
{
    use HasFactory;
    protected $fillable = ['acciones_id', 'nombre', 'categoria_equipo','es_consumible', 'descripcion','estado'];

     //Relacion con las Acciones que se realizan con las municiones
    public function acciones()
    {
        return $this->belongsTo(Acciones::class, 'acciones_id');
    }

    //Relacion con  el inventario Municiones
    public function inventarioMuniciones()
    {
        return $this->hasMany(InventarioMuniciones::class, 'inventario_municiones_id');
    }


}
