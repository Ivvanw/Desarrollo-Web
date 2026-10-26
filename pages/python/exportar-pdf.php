<?php
/**
 * Exporta el reporte del último análisis a PDF usando Python (fpdf).
 */
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../config/config_python.php';
requerirLogin();

date_default_timezone_set('America/Bogota');

$carpeta = RUTA_DATOS . '/' . preg_replace('/[^A-Za-z0-9_-]/', '', session_id());

// Sin análisis previo no hay nada que exportar
if (!is_file($carpeta . '/resumen.json')) {
    $_SESSION['flash_error'] = 'Primero debes subir un CSV para generar el reporte.';
    header('Location: ' . url('pages/python/analisis-datos.php'));
    exit();
}

$pdf = $carpeta . '/reporte_clima_popayan.pdf';

if (is_file($pdf)) {
    unlink($pdf);
}

$salida = ejecutarPython(RUTA_PYTHON . '/reporte_pdf.py', [
    $carpeta,
    $_SESSION['nombre'] ?? 'Estudiante',
    date('Y-m-d H:i'),
    $_SESSION['csv_subido']['nombre'] ?? 'clima.csv',
    $pdf,
]);

if (!is_file($pdf)) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Python no pudo generar el PDF:\n\n" . $salida;
    exit();
}

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="reporte_clima_popayan_' . date('Ymd') . '.pdf"');
header('Content-Length: ' . filesize($pdf));
header('Cache-Control: no-store');
readfile($pdf);
