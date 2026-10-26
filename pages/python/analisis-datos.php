<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../config/config_python.php';
requerirLogin();

date_default_timezone_set('America/Bogota');

/**
 * Convierte "2026-10-20" en "20 de octubre de 2026".
 */
function fechaLarga(string $fecha): string
{
    $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio',
        'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

    $partes = explode('-', $fecha);
    if (count($partes) !== 3) {
        return $fecha;
    }

    return (int) $partes[2] . ' de ' . $meses[(int) $partes[1] - 1] . ' de ' . $partes[0];
}

$titulo = 'Análisis de datos climáticos';
$descripcion = 'Descarga, procesa y visualiza el clima de Popayán con Python.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

// Columnas que debe traer el CSV descargado desde la API
$columnasRequeridas = [
    'fecha', 'temp_max_c', 'temp_min_c', 'temp_media_c',
    'precipitacion_mm', 'humedad_pct', 'viento_max_kmh', 'radiacion_mj_m2',
];

// Carpeta de trabajo propia de cada sesión: datos/<id de sesión>/
$carpeta = RUTA_DATOS . '/' . preg_replace('/[^A-Za-z0-9_-]/', '', session_id());

$mensaje = '';
$tipoMensaje = '';
$detallePython = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv'])) {
    if (!csrfValido($_POST['csrf'] ?? null)) {
        $mensaje = 'La sesión del formulario expiró. Recarga la página e inténtalo de nuevo.';
    } else {
        $archivo = $_FILES['csv'];
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            $mensaje = 'No se recibió el archivo. Selecciona un CSV e inténtalo de nuevo.';
        } elseif ($extension !== 'csv') {
            $mensaje = 'El archivo debe tener extensión .csv.';
        } elseif ($archivo['size'] > 2 * 1024 * 1024) {
            $mensaje = 'El archivo supera el tamaño máximo de 2 MB.';
        } else {
            // Revisar que el encabezado tenga las columnas esperadas
            $manejador = fopen($archivo['tmp_name'], 'r');
            $encabezado = fgetcsv($manejador);
            $filas = 0;

            while (fgetcsv($manejador) !== false) {
                $filas++;
            }

            fclose($manejador);

            $encabezado = array_map(
                fn($columna) => trim($columna, " \t\n\r\0\x0B\xEF\xBB\xBF"),
                $encabezado ?: []
            );
            $faltantes = array_diff($columnasRequeridas, $encabezado);

            if ($faltantes) {
                $mensaje = 'Al CSV le faltan columnas: ' . implode(', ', $faltantes)
                    . '. Usa el archivo descargado en el paso 1.';
            } elseif ($filas === 0) {
                $mensaje = 'El CSV no tiene filas de datos.';
            } else {
                if (!is_dir($carpeta)) {
                    mkdir($carpeta, 0775, true);
                }

                move_uploaded_file($archivo['tmp_name'], $carpeta . '/clima.csv');

                // Borrar el análisis anterior y procesar el CSV con Python
                $anteriores = array_merge(
                    glob($carpeta . '/grafica*.png') ?: [],
                    glob($carpeta . '/resumen.json') ?: []
                );
                array_map('unlink', $anteriores);

                $salida = ejecutarPython(RUTA_PYTHON . '/analisis_clima.py', [
                    $carpeta . '/clima.csv',
                    $carpeta,
                ]);

                // Reintento único: algunos servidores tardan en iniciar Python desde Apache
                if (!is_file($carpeta . '/resumen.json')) {
                    $salida .= "\n--- reintento ---\n" . ejecutarPython(
                        RUTA_PYTHON . '/analisis_clima.py',
                        [$carpeta . '/clima.csv', $carpeta]
                    );
                }

                file_put_contents(
                    $carpeta . '/python.log',
                    date('Y-m-d H:i:s') . "\n" . $salida . "\n"
                );

                if (is_file($carpeta . '/resumen.json')) {
                    $_SESSION['csv_subido'] = [
                        'nombre' => basename($archivo['name']),
                        'filas'  => $filas,
                        'fecha'  => date('Y-m-d H:i'),
                    ];
                    $mensaje = 'Archivo «' . basename($archivo['name']) . "» analizado: $filas registros.";
                    $tipoMensaje = 'exito';
                } else {
                    $mensaje = 'Python no pudo procesar el CSV. Revisa el detalle técnico.';
                    $detallePython = $salida;
                }
            }
        }
    }

    if ($tipoMensaje === '') {
        $tipoMensaje = 'error';
    }
}

// Resultado del último análisis de esta sesión (lo escribe analisis_clima.py)
$resumen = null;
if (is_file($carpeta . '/resumen.json')) {
    $resumen = json_decode((string) file_get_contents($carpeta . '/resumen.json'), true);
}

$dependenciasListas = pythonTieneDependencias();
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de Python · 07</span>
        <h1>Análisis de datos: del CSV al reporte</h1>
        <p>
            Un flujo completo de datos: descargas el clima real de Popayán, subes el archivo,
            Python lo procesa con pandas y matplotlib, y obtienes indicadores, gráficas y un
            reporte en PDF.
        </p>
        <div class="page-actions">
            <a class="boton boton-acento" href="#laboratorio">Ir al laboratorio</a>
            <a class="boton boton-secundario" href="<?= url('pages/python/matplotlib.php') ?>">Repasar Matplotlib</a>
        </div>
    </header>

    <section class="bloque">
        <h2>Objetivos de aprendizaje</h2>
        <ul class="lista-caracteristicas">
            <li>Comprender qué es un archivo CSV y cómo se estructura.</li>
            <li>Leer un CSV con pandas y revisar tipos, nulos y estadísticas.</li>
            <li>Filtrar, limpiar y agrupar datos por mes y por categoría.</li>
            <li>Generar gráficas de líneas, barras, torta, histograma, dispersión y mapa de calor.</li>
            <li>Interpretar los resultados con criterio y exportarlos a PDF.</li>
        </ul>

        <div class="info-box">
            <strong>Fuente de los datos:</strong> la API pública
            <a href="https://open-meteo.com" target="_blank" rel="noopener">Open-Meteo</a> entrega el
            clima diario de los últimos 365 días sin necesidad de clave.
        </div>
    </section>

    <section class="bloque" id="laboratorio">
        <h2>Laboratorio en tres pasos</h2>

        <?php if (!$dependenciasListas): ?>
            <div class="alerta alerta-info">
                <strong>Dependencias pendientes:</strong>
                <span>
                    No se detectaron <code>pandas</code>, <code>matplotlib</code> y <code>fpdf</code>.
                    Instálalas con <code>pip install pandas matplotlib fpdf2</code> para ejecutar el análisis.
                </span>
            </div>
        <?php endif; ?>

        <ol class="pasos">
            <li class="paso">
                <span class="paso-numero">1</span>
                <h3>Descargar los datos</h3>
                <p>Clima diario de Popayán del último año, generado en el momento desde Open-Meteo.</p>
                <a class="boton boton-secundario" href="<?= url('api/clima.php') ?>">
                    <svg class="icono" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 3v12m0 0-5-5m5 5 5-5M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" />
                    </svg>
                    Descargar CSV del clima
                </a>
            </li>

            <li class="paso">
                <span class="paso-numero">2</span>
                <h3>Subir el CSV</h3>
                <form method="POST" enctype="multipart/form-data" id="formulario-csv" class="calc-campos">
                    <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
                    <div class="login-campo">
                        <label for="csv">Archivo CSV</label>
                        <input type="file" id="csv" name="csv" accept=".csv,text/csv" required>
                    </div>
                    <div class="calc-acciones">
                        <button type="submit">
                            <svg class="icono" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 21V9m0 0-5 5m5-5 5 5M4 7V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2" />
                            </svg>
                            Subir y analizar
                        </button>
                    </div>
                </form>
                <p class="small-note">Máximo 2 MB. El archivo debe provenir del paso 1.</p>
            </li>

            <li class="paso<?= $resumen ? ' paso-listo' : '' ?>">
                <span class="paso-numero">3</span>
                <h3>Reporte y PDF</h3>
                <?php if ($resumen): ?>
                    <p>Reporte generado con <?= e($resumen['dias'] ?? 0) ?> días de datos. Revísalo abajo o descárgalo.</p>
                    <a class="boton boton-acento" href="<?= url('pages/python/exportar-pdf.php') ?>">
                        <svg class="icono" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" />
                            <path d="M14 3v6h6M9 15h6M9 18h4" />
                        </svg>
                        Exportar reporte a PDF
                    </a>
                <?php else: ?>
                    <p>Sube el CSV para generar el reporte con sus seis gráficas.</p>
                <?php endif; ?>
            </li>
        </ol>

        <?php if ($mensaje !== ''): ?>
            <div class="alerta alerta-<?= e($tipoMensaje) ?>" role="alert"><?= e($mensaje) ?></div>
        <?php endif; ?>

        <?php if ($detallePython !== ''): ?>
            <div class="alerta alerta-error">
                <strong>Detalle de Python:</strong>
                <pre><code><?= e($detallePython) ?></code></pre>
            </div>
        <?php endif; ?>
    </section>

    <?php if ($resumen): ?>
        <article class="reporte" id="reporte">
            <header class="reporte-encabezado">
                <p class="reporte-etiqueta">Sistema de información climática</p>
                <h2 class="reporte-titulo">Reporte climático de Popayán</h2>
                <p class="reporte-subtitulo">
                    Análisis del clima diario del <?= e(fechaLarga($resumen['fecha_inicio'])) ?>
                    al <?= e(fechaLarga($resumen['fecha_fin'])) ?>
                </p>
                <dl class="reporte-datos">
                    <div>
                        <dt>Fecha del reporte</dt>
                        <dd><?= e(fechaLarga(date('Y-m-d'))) ?>, <?= e(date('H:i')) ?></dd>
                    </div>
                    <div>
                        <dt>Elaborado por</dt>
                        <dd><?= e($_SESSION['nombre'] ?? '') ?></dd>
                    </div>
                    <div>
                        <dt>Archivo analizado</dt>
                        <dd><?= e($_SESSION['csv_subido']['nombre'] ?? 'clima.csv') ?></dd>
                    </div>
                    <div>
                        <dt>Fuente</dt>
                        <dd>Open-Meteo · pandas y matplotlib</dd>
                    </div>
                </dl>
            </header>

            <ul class="indicadores">
                <li>
                    <span class="indicador-valor"><?= e(number_format($resumen['temp_media'], 1, ',', '.')) ?> °C</span>
                    <span class="indicador-nombre">Temperatura media</span>
                </li>
                <li>
                    <span class="indicador-valor"><?= e(number_format($resumen['lluvia_total'], 0, ',', '.')) ?> mm</span>
                    <span class="indicador-nombre">Lluvia acumulada (<?= e($resumen['dias_lluvia']) ?> días)</span>
                </li>
                <li>
                    <span class="indicador-valor"><?= e(number_format($resumen['temp_max'], 1, ',', '.')) ?> °C</span>
                    <span class="indicador-nombre">Máxima · <?= e(fechaLarga($resumen['temp_max_fecha'])) ?></span>
                </li>
                <li>
                    <span class="indicador-valor"><?= e(ucfirst($resumen['mes_lluvioso'])) ?></span>
                    <span class="indicador-nombre">Mes más lluvioso (<?= e(number_format($resumen['mes_lluvioso_mm'], 0, ',', '.')) ?> mm)</span>
                </li>
            </ul>

            <h3 class="reporte-seccion">Resumen</h3>
            <p class="reporte-resumen"><?= e($resumen['texto']) ?></p>

            <h3 class="reporte-seccion">Gráficas</h3>
            <div class="reporte-graficas">
                <?php foreach ($resumen['graficas'] as $numero => $grafica): ?>
                    <figure class="grafica">
                        <img src="<?= url('api/imagen.php') ?>?f=<?= urlencode($grafica['archivo']) ?>&amp;v=<?= time() ?>"
                            alt="<?= e($grafica['titulo']) ?>" loading="lazy">
                        <figcaption>
                            <strong>Figura <?= e($numero + 1) ?>. <?= e($grafica['titulo']) ?>.</strong>
                            <?= e($grafica['descripcion']) ?>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>

            <?php if (!empty($resumen['meses'])): ?>
                <h3 class="reporte-seccion">Resumen por mes</h3>
                <div class="reporte-tabla">
                    <table>
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Días</th>
                                <th>T. media</th>
                                <th>T. máxima</th>
                                <th>T. mínima</th>
                                <th>Lluvia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resumen['meses'] as $mes): ?>
                                <tr>
                                    <td><?= e(ucfirst($mes['mes'])) ?></td>
                                    <td><?= e($mes['dias']) ?></td>
                                    <td><?= e(number_format($mes['temp_media'], 1, ',', '.')) ?> °C</td>
                                    <td><?= e(number_format($mes['temp_max'], 1, ',', '.')) ?> °C</td>
                                    <td><?= e(number_format($mes['temp_min'], 1, ',', '.')) ?> °C</td>
                                    <td><?= e(number_format($mes['lluvia'], 0, ',', '.')) ?> mm</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </article>
    <?php endif; ?>

    <section class="bloque">
        <h2>¿Qué hace el script de Python?</h2>
        <ol class="pasos">
            <li class="paso">
                <span class="paso-numero">1</span>
                <h3>Lee y limpia</h3>
                <p>Convierte la fecha, elimina filas sin temperatura media y rellena la precipitación con cero.</p>
            </li>
            <li class="paso">
                <span class="paso-numero">2</span>
                <h3>Calcula indicadores</h3>
                <p>Temperatura media, máxima, mínima, lluvia acumulada, días de lluvia y correlación humedad-temperatura.</p>
            </li>
            <li class="paso">
                <span class="paso-numero">3</span>
                <h3>Dibuja seis gráficas</h3>
                <p>Líneas, barras, histograma, dispersión, torta y mapa de calor, guardadas como PNG.</p>
            </li>
            <li class="paso">
                <span class="paso-numero">4</span>
                <h3>Escribe resumen.json</h3>
                <p>El reporte de esta página y el PDF se construyen a partir de ese archivo.</p>
            </li>
        </ol>

        <div class="nota">
            <strong>Scripts del proyecto:</strong> <code>python/analisis_clima.py</code> procesa los datos y
            <code>python/reporte_pdf.py</code> genera el PDF con fpdf. Ambos se ejecutan desde PHP con
            <code>shell_exec()</code>.
        </div>
    </section>
</main>

<script>
    // Mientras Python procesa el archivo, avisar y evitar doble envío
    const formularioCsv = document.getElementById('formulario-csv');

    if (formularioCsv) {
        formularioCsv.addEventListener('submit', function () {
            const boton = this.querySelector('button[type="submit"]');
            if (boton) {
                boton.disabled = true;
                boton.textContent = 'Analizando con Python…';
            }
        });
    }
</script>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
