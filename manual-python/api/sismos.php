<?php
/**
 * Descarga como CSV los sismos del último año.
 *
 * Fuente: catálogo de sismos del Servicio Geológico de EE. UU. (USGS),
 * https://earthquake.usgs.gov/fdsnws/event/1/ — gratuito y sin clave.
 *
 * Parámetro ?region=
 *   colombia (por defecto)  Colombia y alrededores, magnitud 2.5 o más.
 *   mundo                   Todo el planeta, magnitud 4.5 o más.
 *
 * El endpoint exige sesión: solo se usa desde el manual de Python.
 */

require_once __DIR__ . '/../../config/auth.php';

if (!estaAutenticado()) {
    http_response_code(401);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Debes iniciar sesión para descargar el archivo de sismos.';
    exit();
}

date_default_timezone_set('America/Bogota');

$regiones = [
    'colombia' => [
        'nombre'   => 'Colombia y alrededores',
        'filtros'  => [
            'minlatitude'  => -4.3,
            'maxlatitude'  => 13.5,
            'minlongitude' => -79.5,
            'maxlongitude' => -66.8,
            'minmagnitude' => 2.5,
        ],
    ],
    'mundo' => [
        'nombre'   => 'Mundo',
        'filtros'  => ['minmagnitude' => 4.5],
    ],
];

$clave = (string) ($_GET['region'] ?? 'colombia');
if (!isset($regiones[$clave])) {
    $clave = 'colombia';
}

$zona = new DateTimeZone('America/Bogota');
$fin = new DateTime('now', $zona);
$inicio = (clone $fin)->modify('-365 days');

$url = 'https://earthquake.usgs.gov/fdsnws/event/1/query?' . http_build_query(array_merge([
    'format'    => 'csv',
    'starttime' => $inicio->format('Y-m-d'),
    'endtime'   => $fin->format('Y-m-d'),
    'eventtype' => 'earthquake',
    'orderby'   => 'time-asc',
], $regiones[$clave]['filtros']));

$curl = curl_init($url);
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 45,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_USERAGENT      => 'TutorWeb/1.0 (material educativo)',
]);
$respuesta = curl_exec($curl);
$codigo = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
$error = curl_error($curl);
curl_close($curl);

if ($respuesta === false || $codigo !== 200) {
    http_response_code(502);
    header('Content-Type: text/plain; charset=utf-8');
    echo "No se pudieron obtener los sismos desde el USGS. {$error} (HTTP {$codigo})";
    exit();
}

// Leer el CSV original del USGS (la columna "place" trae comas entre comillas)
$entrada = fopen('php://memory', 'r+');
fwrite($entrada, $respuesta);
rewind($entrada);

$encabezado = fgetcsv($entrada, 0, ',', '"', '');
$posicion = $encabezado ? array_flip($encabezado) : [];

foreach (['time', 'latitude', 'longitude', 'depth', 'mag', 'magType', 'place'] as $columna) {
    if (!isset($posicion[$columna])) {
        http_response_code(502);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'La respuesta del USGS no tiene el formato esperado.';
        exit();
    }
}

// Escribir un CSV más simple, con columnas en español y hora de Colombia
$salida = fopen('php://temp', 'r+');
fputcsv($salida, ['fecha', 'hora', 'latitud', 'longitud', 'profundidad_km', 'magnitud', 'tipo_magnitud', 'lugar'], ',', '"', '');

while (($fila = fgetcsv($entrada, 0, ',', '"', '')) !== false) {
    if (count($fila) < count($encabezado) || $fila[$posicion['mag']] === '') {
        continue;
    }

    $momento = new DateTime($fila[$posicion['time']]);
    $momento->setTimezone($zona);

    fputcsv($salida, [
        $momento->format('Y-m-d'),
        $momento->format('H:i:s'),
        round((float) $fila[$posicion['latitude']], 4),
        round((float) $fila[$posicion['longitude']], 4),
        round((float) $fila[$posicion['depth']], 1),
        round((float) $fila[$posicion['mag']], 1),
        $fila[$posicion['magType']],
        $fila[$posicion['place']],
    ], ',', '"', '');
}
fclose($entrada);

rewind($salida);
$csv = stream_get_contents($salida);
fclose($salida);

$nombre = 'sismos_' . $clave . '_' . $inicio->format('Ymd') . '_' . $fin->format('Ymd') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $nombre . '"');
header('Content-Length: ' . strlen($csv));
header('Cache-Control: no-store');
echo $csv;
