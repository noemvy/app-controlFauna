<?php

namespace App\Http\Controllers;

use App\Models\CatalogoInventario;
use App\Models\IntervencionesEventoDraft;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFIntervencionesEvento extends Controller
{
    /**
     * Genera y descarga el PDF del reporte de impacto con fauna.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function generatePDF(int $id)
    {
    // Obtener el reporte con relaciones necesarias
    $reporte = IntervencionesEventoDraft::with([
    'user',
    'especie',
    'grupo',
    'catalogoInventario',
    'accion',
    'atractivo',
    'inventarioMuniciones',
    ])->findOrFail($id);
    $municionesInfo = [];

    /*municion_utilizada es el arreglo que se llena en el repeater de intervenciones_draft, aqui se obtienen los datos para
    mostrarlos en el pdf ya que se pueden elegir multiples municones, junto con acciones y la cantidad de cada una.*/
    foreach ($reporte->municion_utilizada ?? [] as $item) {
    $catalogo = CatalogoInventario::with('acciones')->find($item['catinventario_id']);

    if ($catalogo) {
        $municionesInfo[] = [
            'nombre' => $catalogo->nombre,
            'accion' => $catalogo->acciones->nombre ?? 'Sin acción',
            'cantidad_utilizada' => $item['cantidad_utilizada'],
        ];
    }
    }

    // Generar PDF
    $pdf = Pdf::loadView('pdf.evento-intervenciones', [
    'reporte' => $reporte,
    'municionesInfo' => $municionesInfo,
    ]
    )->setPaper('letter', 'portrait');

    // Descargar el archivo PDF
    return $pdf->download("EventoIntervenciones-{$reporte->id}.pdf");
}
}
