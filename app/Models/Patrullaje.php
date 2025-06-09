<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patrullaje extends Model
{
    protected $fillable = ['aerodromo_id', 'user_id', 'estado','inicio', 'fin','comentarios'];
    protected $table = 'patrullaje';


    protected static function booted()
{
    static::deleting(function ($patrullaje) {
        $patrullaje->intervenciones()->delete();
    });
}

//Relacion con Aerodromo
    public function aerodromo()
{
    return $this->belongsTo(Aerodromo::class, 'aerodromo_id');
}

//Relacion con User
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function intervenciones()
{
    return $this->hasMany(Intervenciones::class);
}

public function intervencionesDraft()
{
    return $this->hasMany(Intervenciones::class);
}





}
