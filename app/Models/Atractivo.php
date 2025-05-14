<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atractivo extends Model
{
    use HasFactory;
    protected $table = 'atractivos';
    protected $fillable = ['nombre'];
}
