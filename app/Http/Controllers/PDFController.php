<?php

namespace App\Http\Controllers;

use App\Models\ReporteImpactoAviar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
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
        $reporte = ReporteImpactoAviar::with([
            'aerodromo',
            'pista',
            'aerolinea',
            'modelo',
            'especie',
            'partesGolpeadas',
            'partesDanadas',
            'user',
            'actualizaciones',
        ])->findOrFail($id);

        // Obtener relaciones ya cargadas o colecciones vacías
        $partesGolpeadas = $reporte->partesGolpeadas ?? collect();
        $partesDanadas = $reporte->partesDanadas ?? collect();

        // Contadores para estructura de tabla en la vista
        $countPartesGolpeadas = max(1, $partesGolpeadas->count());
        $countPartesDanadas = max(1, $partesDanadas->count());

        // Generar PDF
        $pdf = Pdf::loadView('pdf.reporte-ifa', compact(
            'reporte',
            'partesGolpeadas',
            'partesDanadas',
            'countPartesGolpeadas',
            'countPartesDanadas'
        ))->setPaper('letter', 'portrait');

        // Descargar el archivo PDF
        return $pdf->download("ReporteImpacto-{$reporte->codigo}.pdf");
    }
}
