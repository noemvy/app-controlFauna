<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acciones extends Model
{
    use HasFactory;
     protected $table = 'acciones';

    protected $fillable = ['nombre'];


    // Relación uno a muchos con CatalogoInventario
    public function catalogoInventario()
    {
        return $this->hasMany(CatalogoInventario::class, 'acciones_id');
        // 'accion_id' es la llave foránea en la tabla catalogo_inventario que referencia a acciones.id
    }
}
