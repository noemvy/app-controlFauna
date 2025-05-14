<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patrullaje extends Model
{
    protected $fillable = ['aerodromo_id', 'users_id', 'inicio', 'fin'];

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


}
