<?php
/**
 * Portada del tutor de PHP (acceso libre).
 * El manual de Python vive aparte en manual-python/ con su propio menú y login.
 */
require_once __DIR__ . '/config/auth.php';

$titulo = 'Inicio';
$descripcion = 'Tutor de desarrollo web y manual de PHP.';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="hero-info">
        <span class="saludo-bienvenida">
            <span aria-hidden="true">●</span>
            Bienvenido, <?= e($_SESSION['nombre'] ?? 'estudiante') ?>
        </span>
        <h1>Bienvenido al mundo de PHP.</h1>
        <p>
            PHP (<strong>PHP: Hypertext Preprocessor</strong>) es un lenguaje de código abierto pensado
            para la web. Se ejecuta en el <em>servidor</em> y el navegador recibe solo el HTML resultante.
            Aquí encontrarás la teoría del desarrollo web y un manual de PHP con ejemplos que se ejecutan de verdad.
        </p>

        <div class="page-actions">
            <a class="boton" href="<?= url('pages/php/index.php') ?>">Empezar con PHP</a>
            <a class="boton boton-secundario" href="<?= url('pages/web/conceptos.php') ?>">Repasar conceptos web</a>
            <a class="boton boton-acento" href="<?= url('manual-python/index.php') ?>">Ir al manual de Python</a>
        </div>

        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🐘</span>
                <h3>Lenguaje del servidor</h3>
                <p>Se ejecuta en el backend, no en el navegador del usuario.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">⚡</span>
                <h3>Rápido y dinámico</h3>
                <p>Genera HTML en tiempo real según cada petición.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🔓</span>
                <h3>Código abierto</h3>
                <p>Gratuito, con una comunidad enorme y miles de librerías.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🌐</span>
                <h3>Multiplataforma</h3>
                <p>Funciona en Windows, Linux y macOS sin cambios.</p>
            </article>
        </div>
    </section>

    <section class="bloque">
        <div class="fila-encabezado">
            <div>
                <span class="section-kicker">Tutor de PHP</span>
                <h2 class="mb-0">Módulos</h2>
            </div>
            <span class="badge-pill verde">Acceso libre</span>
        </div>

        <div class="dashboard-grid">
            <a class="tarjeta" href="<?= url('pages/web/conceptos.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">🏛️</span>
                <h3>Evolución de sistemas</h3>
                <p>Mainframe, terminales, cliente-servidor, dos y tres niveles, multinivel.</p>
                <span class="tarjeta-pie">Abrir módulo →</span>
            </a>

            <a class="tarjeta" href="<?= url('pages/web/frontend.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">🎨</span>
                <h3>Frontend</h3>
                <p>HTML, CSS, JavaScript y los frameworks que dominan la interfaz.</p>
                <span class="tarjeta-pie">Abrir módulo →</span>
            </a>

            <a class="tarjeta" href="<?= url('pages/web/backend.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">⚙️</span>
                <h3>Backend</h3>
                <p>Servidores, lenguajes, bases de datos y lógica de negocio.</p>
                <span class="tarjeta-pie">Abrir módulo →</span>
            </a>

            <a class="tarjeta" href="<?= url('pages/php/index.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">🐘</span>
                <h3>Manual de PHP</h3>
                <p>Variables, condicionales, ciclos, vectores, sesiones y bases de datos.</p>
                <span class="tarjeta-pie">Abrir módulo →</span>
            </a>

            <a class="tarjeta" href="<?= url('pages/ia.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">🤖</span>
                <h3>Inteligencia artificial</h3>
                <p>Qué es, cómo se aplica y qué límites tiene hoy.</p>
                <span class="tarjeta-pie">Abrir módulo →</span>
            </a>

            <a class="tarjeta" href="<?= url('pages/material/index.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">🗂️</span>
                <h3>Material de clase</h3>
                <p>Ejercicios históricos de HTML y la clase de CSV con Matplotlib.</p>
                <span class="tarjeta-pie">Ver material →</span>
            </a>
        </div>
    </section>

    <section class="bloque">
        <div class="fila-encabezado">
            <div>
                <span class="section-kicker">Área privada</span>
                <h2 class="mb-0">Manual de Python</h2>
            </div>
            <span class="badge-pill naranja">Requiere contraseña</span>
        </div>

        <p>
            El manual de Python está separado del tutor de PHP, con su propio menú. Incluye conceptos,
            gráficas, Matplotlib y un laboratorio que descarga los sismos reales del último año, los analiza con
            pandas y exporta un reporte en PDF.
        </p>

        <div class="dashboard-grid">
            <a class="tarjeta" href="<?= url('manual-python/index.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">🐍</span>
                <h3>Manual de Python</h3>
                <p>Sintaxis, variables, operadores, comandos y gráficas.</p>
                <span class="tarjeta-pie">Entrar →</span>
            </a>

            <a class="tarjeta destacada" href="<?= url('manual-python/analisis-datos.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">📊</span>
                <h3>Análisis de sismos</h3>
                <p>Descarga los sismos del USGS, procésalos con pandas y exporta un reporte en PDF.</p>
                <span class="tarjeta-pie">Abrir laboratorio →</span>
            </a>
        </div>
    </section>

    <section class="bloque">
        <span class="section-kicker">Ruta sugerida</span>
        <h2>¿Por dónde empezar?</h2>

        <ol class="pasos">
            <li class="paso">
                <span class="paso-numero">1</span>
                <h3>Entiende el contexto</h3>
                <p>Repasa la evolución de los sistemas computacionales y el modelo cliente-servidor.</p>
                <a class="boton boton-secundario" href="<?= url('pages/web/conceptos.php') ?>">Ir a conceptos</a>
            </li>
            <li class="paso">
                <span class="paso-numero">2</span>
                <h3>Construye la interfaz</h3>
                <p>Aprende HTML, CSS y JavaScript, y cómo se conectan con el servidor.</p>
                <a class="boton boton-secundario" href="<?= url('pages/web/frontend.php') ?>">Ir a frontend</a>
            </li>
            <li class="paso">
                <span class="paso-numero">3</span>
                <h3>Programa el servidor</h3>
                <p>Practica PHP con variables, condicionales, ciclos, vectores y sesiones.</p>
                <a class="boton boton-secundario" href="<?= url('pages/php/index.php') ?>">Ir a PHP</a>
            </li>
            <li class="paso">
                <span class="paso-numero">4</span>
                <h3>Analiza los datos</h3>
                <p>Inicia sesión en el manual de Python y convierte un CSV en un reporte visual.</p>
                <a class="boton boton-secundario" href="<?= url('manual-python/index.php') ?>">Ir a Python</a>
            </li>
        </ol>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
