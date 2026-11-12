<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/config_python.php';
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

$titulo = 'Análisis de datos sísmicos';
$descripcion = 'Descarga, procesa y visualiza los sismos del último año con Python.';
require __DIR__ . '/../includes/head.php';
require __DIR__ . '/../includes/header-python.php';

// Columnas que debe traer el CSV descargado desde la API
$columnasRequeridas = [
    'fecha', 'hora', 'latitud', 'longitud', 'profundidad_km', 'magnitud', 'tipo_magnitud', 'lugar',
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
                    mkdir($carpeta, 0777, true);
                }

                move_uploaded_file($archivo['tmp_name'], $carpeta . '/sismos.csv');

                // Borrar el análisis anterior y procesar el CSV con Python
                $anteriores = array_merge(
                    glob($carpeta . '/grafica*.png') ?: [],
                    glob($carpeta . '/resumen.json') ?: []
                );
                array_map('unlink', $anteriores);

                $salida = ejecutarPython(RUTA_PYTHON . '/analisis_sismos.py', [
                    $carpeta . '/sismos.csv',
                    $carpeta,
                ]);

                // Reintento único: algunos servidores tardan en iniciar Python desde Apache
                if (!is_file($carpeta . '/resumen.json')) {
                    $salida .= "\n--- reintento ---\n" . ejecutarPython(
                        RUTA_PYTHON . '/analisis_sismos.py',
                        [$carpeta . '/sismos.csv', $carpeta]
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

// Resultado del último análisis de esta sesión (lo escribe analisis_sismos.py)
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
            Un flujo completo de datos: descargas los sismos reales del último año, subes el archivo,
            Python lo procesa con pandas y matplotlib, y obtienes indicadores, gráficas y un
            reporte en PDF.
        </p>
        <div class="page-actions">
            <a class="boton boton-acento" href="#laboratorio">Ir al laboratorio</a>
            <a class="boton boton-secundario" href="<?= url('manual-python/matplotlib.php') ?>">Repasar Matplotlib</a>
        </div>
    </header>

    <section class="bloque">
        <h2>Objetivos de aprendizaje</h2>
        <ul class="lista-caracteristicas">
            <li>Comprender qué es un archivo CSV y cómo se estructura.</li>
            <li>Leer un CSV con pandas y revisar tipos, nulos y estadísticas.</li>
            <li>Filtrar, limpiar y agrupar datos por mes y por categoría.</li>
            <li>Generar gráficas de barras, histograma, dispersión, mapa de puntos y dona.</li>
            <li>Interpretar los resultados con criterio y exportarlos a PDF.</li>
        </ul>

        <div class="info-box">
            <strong>Fuente de los datos:</strong> el catálogo público de sismos del
            <a href="https://earthquake.usgs.gov/fdsnws/event/1/" target="_blank" rel="noopener">Servicio Geológico
            de EE. UU. (USGS)</a> entrega fecha, magnitud, profundidad y ubicación de cada sismo, sin clave.
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
                <p>Sismos del último año, descargados en el momento desde el USGS. Elige la región:</p>
                <div class="calc-acciones">
                    <a class="boton boton-secundario" href="<?= url('manual-python/api/sismos.php') ?>?region=colombia">
                        <svg class="icono" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 3v12m0 0-5-5m5 5 5-5M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" />
                        </svg>
                        Colombia y alrededores (M 2.5+)
                    </a>
                    <a class="boton boton-secundario" href="<?= url('manual-python/api/sismos.php') ?>?region=mundo">
                        <svg class="icono" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 3v12m0 0-5-5m5 5 5-5M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" />
                        </svg>
                        Todo el mundo (M 4.5+)
                    </a>
                </div>
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
                    <p>Reporte generado con <?= e($resumen['total'] ?? 0) ?> sismos. Revísalo abajo o descárgalo.</p>
                    <a class="boton boton-acento" href="<?= url('manual-python/exportar-pdf.php') ?>">
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
                <p class="reporte-etiqueta">Sistema de información sísmica</p>
                <h2 class="reporte-titulo">Reporte de sismos: <?= e($resumen['region'] ?? '') ?></h2>
                <p class="reporte-subtitulo">
                    Sismos registrados del <?= e(fechaLarga($resumen['fecha_inicio'])) ?>
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
                        <dd><?= e($_SESSION['csv_subido']['nombre'] ?? 'sismos.csv') ?></dd>
                    </div>
                    <div>
                        <dt>Fuente</dt>
                        <dd>USGS · pandas y matplotlib</dd>
                    </div>
                </dl>
            </header>

            <ul class="indicadores">
                <li>
                    <span class="indicador-valor"><?= e(number_format($resumen['total'], 0, ',', '.')) ?></span>
                    <span class="indicador-nombre">Sismos (<?= e($resumen['fuertes']) ?> de magnitud 5 o más)</span>
                </li>
                <li>
                    <span class="indicador-valor">M <?= e(number_format($resumen['magnitud_max'], 1, ',', '.')) ?></span>
                    <span class="indicador-nombre">Mayor · <?= e(fechaLarga($resumen['magnitud_max_fecha'])) ?></span>
                </li>
                <li>
                    <span class="indicador-valor"><?= e(number_format($resumen['magnitud_media'], 2, ',', '.')) ?></span>
                    <span class="indicador-nombre">Magnitud promedio · profundidad <?= e(number_format($resumen['profundidad_media'], 0, ',', '.')) ?> km</span>
                </li>
                <li>
                    <span class="indicador-valor"><?= e(ucfirst($resumen['mes_activo'])) ?></span>
                    <span class="indicador-nombre">Mes más activo (<?= e($resumen['mes_activo_sismos']) ?> sismos)</span>
                </li>
            </ul>

            <h3 class="reporte-seccion">Resumen</h3>
            <p class="reporte-resumen"><?= e($resumen['texto']) ?></p>

            <h3 class="reporte-seccion">Gráficas</h3>
            <div class="reporte-graficas">
                <?php foreach ($resumen['graficas'] as $numero => $grafica): ?>
                    <figure class="grafica">
                        <img src="<?= url('manual-python/api/imagen.php') ?>?f=<?= urlencode($grafica['archivo']) ?>&amp;v=<?= time() ?>"
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
                                <th>Sismos</th>
                                <th>Magnitud media</th>
                                <th>Magnitud máxima</th>
                                <th>Profundidad media</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resumen['meses'] as $mes): ?>
                                <tr>
                                    <td><?= e(ucfirst($mes['mes'])) ?></td>
                                    <td><?= e($mes['sismos']) ?></td>
                                    <td><?= e(number_format($mes['magnitud_media'], 2, ',', '.')) ?></td>
                                    <td><?= e(number_format($mes['magnitud_max'], 1, ',', '.')) ?></td>
                                    <td><?= e(number_format($mes['profundidad_media'], 1, ',', '.')) ?> km</td>
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
                <p>Convierte la fecha y los números, elimina filas sin magnitud o ubicación y extrae la zona de cada sismo.</p>
            </li>
            <li class="paso">
                <span class="paso-numero">2</span>
                <h3>Calcula indicadores</h3>
                <p>Total de sismos, magnitud promedio y máxima, profundidad, mes más activo, zona con más registros y correlación profundidad-magnitud.</p>
            </li>
            <li class="paso">
                <span class="paso-numero">3</span>
                <h3>Dibuja seis gráficas</h3>
                <p>Barras por mes, histograma, dispersión, mapa de epicentros, dona por profundidad y ranking de zonas, guardadas como PNG.</p>
            </li>
            <li class="paso">
                <span class="paso-numero">4</span>
                <h3>Escribe resumen.json</h3>
                <p>El reporte de esta página y el PDF se construyen a partir de ese archivo.</p>
            </li>
        </ol>

        <div class="nota">
            <strong>Scripts del proyecto:</strong> <code>python/analisis_sismos.py</code> procesa los datos y
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

<?php require __DIR__ . '/../includes/footer.php'; ?>
