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
    'pivoteEvento.catalogoInventario',
    'pivoteEvento.acciones',
    'actualizacionesEvento',
    ])->findOrFail($id);


    // Generar PDF
    $pdf = Pdf::loadView('pdf.evento-intervenciones', [
    'reporte' => $reporte,
    ]
    )->setPaper('letter', 'portrait');

    // Descargar el archivo PDF
    return $pdf->download("EventoIntervenciones-{$reporte->id}.pdf");
}
}
