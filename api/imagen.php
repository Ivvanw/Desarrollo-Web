<?php
/**
 * Entrega una gráfica PNG generada por Python para la sesión actual.
 *
 * Solo se sirven archivos con el patrón graficaN_nombre.png dentro de la
 * carpeta de la sesión; cualquier otra ruta devuelve 404.
 */

require_once __DIR__ . '/../config/auth.php';

if (!estaAutenticado()) {
    http_response_code(401);
    exit();
}

$archivo = basename((string) ($_GET['f'] ?? ''));
$sesion = preg_replace('/[^A-Za-z0-9_-]/', '', session_id());
$ruta = RUTA_DATOS . '/' . $sesion . '/' . $archivo;

if (!preg_match('/^grafica\d+_[a-z_]+\.png$/', $archivo) || !is_file($ruta)) {
    http_response_code(404);
    exit();
}

header('Content-Type: image/png');
header('Content-Length: ' . filesize($ruta));
header('Cache-Control: no-store');
readfile($ruta);
