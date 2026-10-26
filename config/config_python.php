<?php
/**
 * Utilidades para ejecutar los scripts de Python desde PHP.
 */

/**
 * Busca el intérprete de Python disponible en el sistema.
 */
function rutaPython(): string
{
    $candidatos = [];

    if (getenv('PYTHON_BIN')) {
        $candidatos[] = getenv('PYTHON_BIN');
    }

    // Instalaciones típicas de Python en Windows (XAMPP suele no tener el PATH)
    $carpetasUsuario = glob('C:/Users/*/AppData/Local/Programs/Python/Python3*/python.exe') ?: [];
    $carpetasSistema = array_merge(
        glob('C:/Program Files/Python3*/python.exe') ?: [],
        glob('C:/Python3*/python.exe') ?: []
    );
    rsort($carpetasUsuario);
    rsort($carpetasSistema);
    $candidatos = array_merge($candidatos, $carpetasUsuario, $carpetasSistema);

    // Rutas habituales en Linux y macOS
    $candidatos = array_merge($candidatos, ['/usr/bin/python3', '/usr/local/bin/python3']);

    foreach ($candidatos as $ruta) {
        if (is_file($ruta)) {
            return $ruta;
        }
    }

    return 'python3';
}

/**
 * Ejecuta un script de Python con sus argumentos y devuelve stdout + stderr.
 */
function ejecutarPython(string $script, array $argumentos = []): string
{
    $comando = escapeshellarg(rutaPython()) . ' ' . escapeshellarg($script);

    foreach ($argumentos as $argumento) {
        $comando .= ' ' . escapeshellarg((string) $argumento);
    }

    $salida = trim((string) shell_exec($comando . ' 2>&1'));

    // En Windows, cmd.exe entrega los mensajes en CP850
    if ($salida !== '' && !mb_check_encoding($salida, 'UTF-8')) {
        $salida = mb_convert_encoding($salida, 'UTF-8', 'CP850');
    }

    return $salida;
}

/**
 * Comprueba si las librerías usadas por el análisis están instaladas.
 */
function pythonTieneDependencias(): bool
{
    $salida = ejecutarPython('-c', ['import pandas, matplotlib, fpdf']);
    return $salida === '';
}
