<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = ['aerodromo_id', 'user_id', 'tipo_evento', 'comentario'];
    protected $table = 'evento';
    //Relacion con Aerodromo
        public function aerodromo()
    {
        return $this->belongsTo(Aerodromo::class, 'aerodromo_id');
    }
    //Relacion con  User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function intervencionesEvento()
    {
        return $this->hasMany(Intervenciones::class);
    }
    public function intervencionesEventoDraft()
    {
        return $this->hasMany(Intervenciones::class);
    }




}
