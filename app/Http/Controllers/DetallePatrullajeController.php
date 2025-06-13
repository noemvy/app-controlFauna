<?php

namespace App\Http\Controllers;

use App\Models\Patrullaje;
use Illuminate\Http\Request;

class DetallePatrullajeController extends Controller
{
    public function show(Patrullaje $patrullaje)
{
    $intervenciones = $patrullaje->intervenciones()

    ->paginate(5);

    return view('components.patrullaje-detalles',[
        'patrullaje'=> $patrullaje,
        'intervenciones'=> $intervenciones,

    ]);
}
}
