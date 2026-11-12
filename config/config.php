<?php
/**
 * Configuración general del sitio.
 *
 * Calcula la URL base del proyecto para que las páginas funcionen tanto si
 * se sirven desde la raíz del servidor como desde una subcarpeta
 * (por ejemplo http://localhost/Desarrollo-Web/).
 */

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');

    $seguro = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['SERVER_PORT'] ?? '') === '443');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $seguro,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}

define('APP_NOMBRE', 'Tutor Web');
define('APP_AUTOR', 'Ivan Andres Chimunja Beltran');
define('APP_CORREO', 'ichimunja@unimayor.edu.co');
define('APP_UNIVERSIDAD', 'https://www.unimayor.edu.co');

// Rutas absolutas dentro del servidor
define('RAIZ', dirname(__DIR__));
define('RUTA_PYTHON', RAIZ . '/python');
define('RUTA_DATOS', RAIZ . '/datos');

/**
 * Devuelve la URL base del proyecto (con barra final).
 */
function calcularBaseUrl(): string
{
    $documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '';
    $proyecto = realpath(RAIZ) ?: RAIZ;

    $documentRoot = str_replace('\\', '/', $documentRoot);
    $proyecto = str_replace('\\', '/', $proyecto);

    if ($documentRoot !== '' && str_starts_with($proyecto, $documentRoot)) {
        $base = substr($proyecto, strlen($documentRoot));
        return rtrim($base, '/') . '/';
    }

    return '/';
}

define('BASE_URL', calcularBaseUrl());

/**
 * Construye una URL interna del sitio.
 */
function url(string $ruta = ''): string
{
    return BASE_URL . ltrim($ruta, '/');
}

/**
 * Escapa texto para imprimirlo en HTML.
 */
function e(mixed $texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

/**
 * Comprueba si la página indicada es la actual (para resaltar el menú).
 */
function paginaActual(string $ruta): bool
{
    $actual = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $objetivo = str_replace('\\', '/', url($ruta));

    return $actual === $objetivo || str_ends_with($actual, '/' . ltrim($ruta, '/'));
}

/**
 * Devuelve la clase "active" cuando la ruta coincide.
 */
function activo(string $ruta): string
{
    return paginaActual($ruta) ? ' active' : '';
}

/**
 * Devuelve la clase "active" cuando la ruta actual está dentro de una carpeta.
 */
function activoCarpeta(string $carpeta): string
{
    $actual = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    return str_contains($actual, '/' . trim($carpeta, '/') . '/') ? ' active' : '';
}

/**
 * Íconos propios del sitio (SVG de líneas rectas que heredan el color del texto).
 *   tutor  -> terminal entre corchetes  [>_]
 *   python -> barras de datos entre corchetes
 */
function icono(string $nombre, int $tamano = 20): string
{
    $trazos = [
        'tutor'  => '<path d="M5 3H2v18h3M19 3h3v18h-3"/><path d="M7 8l4 4-4 4"/><path d="M13 16h5"/>',
        'python' => '<path d="M5 3H2v18h3M19 3h3v18h-3"/><path d="M7 17v-4M11 17V7M15 17v-7"/><path d="M6.5 17.5h11"/>',
    ];

    return '<svg class="icono-marca" width="' . $tamano . '" height="' . $tamano . '" viewBox="0 0 24 24" fill="none" '
        . 'stroke="currentColor" stroke-width="2.2" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">'
        . ($trazos[$nombre] ?? $trazos['tutor']) . '</svg>';
}
