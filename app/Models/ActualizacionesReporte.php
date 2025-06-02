<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ActualizacionesReporte extends Model
{
    use HasFactory;
    protected $table = 'actualizacion_reportes';

    protected $fillable = ['actualizacion', 'autor'];

    public function reportable()
    {
        return $this->morphTo();
    }

    public function user()
{
    return $this->belongsTo(User::class, 'autor');
}

}

