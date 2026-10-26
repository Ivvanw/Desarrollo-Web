<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Material del curso';
$descripcion = 'Índice de material, ejercicios y recursos del tutor de desarrollo web.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

$modulos = [
    [
        'icono' => '🧱',
        'titulo' => 'HTML básico',
        'descripcion' => 'Estructura, texto, tablas, imágenes, enlaces, listas, carrusel y primeros estilos.',
        'ruta' => 'pages/material/html-basico/index.php',
        'etiqueta' => '9 lecciones',
    ],
    [
        'icono' => '🎨',
        'titulo' => 'CSS',
        'descripcion' => 'Cascada, especificidad, formas de uso y una demostración interactiva.',
        'ruta' => 'pages/web/css.php',
        'etiqueta' => 'Módulo web',
    ],
    [
        'icono' => '🌐',
        'titulo' => 'Desarrollo web',
        'descripcion' => 'Evolución de los sistemas, frontend, backend, APIs y presentación del autor.',
        'ruta' => 'pages/web/conceptos.php',
        'etiqueta' => '6 páginas',
    ],
    [
        'icono' => '🐘',
        'titulo' => 'Manual de PHP',
        'descripcion' => 'Variables, condicionales, ciclos, vectores, sesiones y bases de datos.',
        'ruta' => 'pages/php/index.php',
        'etiqueta' => '7 páginas',
    ],
    [
        'icono' => '🐍',
        'titulo' => 'Manual de Python',
        'descripcion' => 'Variables, operadores, comandos, gráficas, CSV, Matplotlib y análisis climático.',
        'ruta' => 'pages/python/index.php',
        'etiqueta' => '8 páginas',
    ],
    [
        'icono' => '🤖',
        'titulo' => 'Inteligencia artificial',
        'descripcion' => 'Conceptos, usos en la web, buenas prácticas y un clasificador de ejemplo.',
        'ruta' => 'pages/ia.php',
        'etiqueta' => 'Módulo complementario',
    ],
];
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Material</span>
        <h1>Material y ejercicios del curso</h1>
        <p>
            Todo el contenido del tutor está organizado por temas. Puedes recorrer los módulos en orden
            o entrar directamente al que necesites repasar. Cada página incluye explicación, ejemplos y
            actividades.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/material/html-basico/index.php') ?>">Empezar por HTML</a>
            <a class="boton boton-secundario" href="<?= url('inicio.php') ?>">Volver al inicio</a>
        </div>
    </header>

    <section class="bloque">
        <div class="fila-encabezado">
            <div>
                <span class="section-kicker">Ruta de aprendizaje</span>
                <h2 class="mb-0">Módulos disponibles</h2>
            </div>
            <span class="badge-pill">6 módulos</span>
        </div>

        <div class="grid-cards">
            <?php foreach ($modulos as $modulo): ?>
                <article class="tarjeta">
                    <span class="tarjeta-icono" aria-hidden="true"><?= e($modulo['icono']) ?></span>
                    <h3><?= e($modulo['titulo']) ?></h3>
                    <p><?= e($modulo['descripcion']) ?></p>
                    <p><small class="small-note"><?= e($modulo['etiqueta']) ?></small></p>
                    <a class="boton boton-secundario" href="<?= url($modulo['ruta']) ?>">Abrir módulo</a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="bloque">
        <h2>Ruta sugerida</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Paso</th>
                        <th>Tema</th>
                        <th>Qué aprenderás</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>HTML básico</td><td>Construir la estructura y el contenido de una página.</td></tr>
                    <tr><td>2</td><td>CSS</td><td>Dar estilo, adaptar a móviles y organizar el diseño.</td></tr>
                    <tr><td>3</td><td>Desarrollo web</td><td>Entender frontend, backend, APIs y arquitecturas.</td></tr>
                    <tr><td>4</td><td>PHP</td><td>Generar contenido dinámico y proteger páginas con sesiones.</td></tr>
                    <tr><td>5</td><td>Python</td><td>Automatizar tareas, graficar y analizar datos.</td></tr>
                    <tr><td>6</td><td>IA</td><td>Usar asistentes y modelos con criterio y responsabilidad.</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="bloque">
        <h2>Recursos y ejemplos</h2>
        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🖼️</span>
                <h3>Diagramas web</h3>
                <p>Ilustraciones de mainframe, terminales, cliente-servidor y arquitecturas multinivel.</p>
                <a class="boton boton-secundario" href="<?= url('pages/web/conceptos.php') ?>">Ver diagramas</a>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">📈</span>
                <h3>Gráficas</h3>
                <p>Ejemplos con Chart.js y galería de gráficas generadas con Matplotlib.</p>
                <a class="boton boton-secundario" href="<?= url('pages/python/matplotlib.php') ?>">Ver galería</a>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🧾</span>
                <h3>Facturas de ejemplo</h3>
                <p>Imágenes de facturas usadas para practicar maquetación y análisis de documentos.</p>
                <a class="boton boton-secundario" href="<?= url('assets/img/ejemplos/Factura_universitaria_con_mascota_felina.png') ?>" target="_blank" rel="noopener">Abrir ejemplo</a>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🌦️</span>
                <h3>Análisis climático</h3>
                <p>Sube un CSV, genera un reporte y descarga un PDF con los resultados.</p>
                <a class="boton boton-secundario" href="<?= url('pages/python/analisis-datos.php') ?>">Ir al laboratorio</a>
            </article>
        </div>
    </section>

    <section class="bloque">
        <h2>Cómo usar el material</h2>
        <ul class="lista-caracteristicas">
            <li><strong>Lee primero:</strong> cada página explica el concepto antes de mostrar código.</li>
            <li><strong>Prueba los ejemplos:</strong> modifica valores y observa qué cambia.</li>
            <li><strong>Haz los ejercicios:</strong> programar se aprende escribiendo, no solo leyendo.</li>
            <li><strong>Vuelve cuando lo necesites:</strong> el menú superior te lleva a cualquier módulo.</li>
        </ul>

        <div class="info-box">
            <strong>Recuerda:</strong> este sitio requiere iniciar sesión. Si cierras la sesión, todas las
            páginas del material quedarán bloqueadas hasta que vuelvas a entrar.
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
