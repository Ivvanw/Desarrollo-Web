<?php
require_once __DIR__ . '/config/auth.php';
requerirLogin();

$titulo = 'Inicio';
$descripcion = 'Panel principal del tutor de desarrollo web, PHP y Python.';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="hero-info">
        <span class="saludo-bienvenida">
            <span aria-hidden="true">●</span>
            Bienvenido, <?= e($_SESSION['nombre'] ?? 'estudiante') ?>
        </span>
        <h1>Un tutor completo para aprender haciendo.</h1>
        <p>
            Aquí encontrarás la teoría esencial del desarrollo web, manuales de PHP y Python,
            demos que se ejecutan en el servidor y un flujo real de análisis de datos.
            Todo el contenido está protegido: solo se abre con una sesión iniciada.
        </p>

        <div class="page-actions">
            <a class="boton" href="<?= url('pages/php/index.php') ?>">Empezar con PHP</a>
            <a class="boton boton-acento" href="<?= url('pages/python/analisis-datos.php') ?>">Ver análisis de datos</a>
            <a class="boton boton-secundario" href="<?= url('pages/web/conceptos.php') ?>">Repasar conceptos web</a>
        </div>

        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🌐</span>
                <h3>Web</h3>
                <p>Evolución de los sistemas, frontend, backend, APIs y CSS.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🐘</span>
                <h3>PHP</h3>
                <p>Variables, condicionales, ciclos, vectores, sesiones y bases de datos.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🐍</span>
                <h3>Python</h3>
                <p>Fundamentos, gráficas, CSV, Matplotlib y análisis de datos reales.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🤖</span>
                <h3>IA</h3>
                <p>Conceptos, aplicaciones y buenas prácticas de inteligencia artificial.</p>
            </article>
        </div>
    </section>

    <section class="bloque">
        <div class="fila-encabezado">
            <div>
                <span class="section-kicker">Explorar</span>
                <h2 class="mb-0">Módulos del tutor</h2>
            </div>
            <span class="badge-pill verde">Sesión protegida</span>
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
                <p>Del primer script a las sesiones y el acceso a datos.</p>
                <span class="tarjeta-pie">Abrir módulo →</span>
            </a>

            <a class="tarjeta" href="<?= url('pages/python/index.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">🐍</span>
                <h3>Manual de Python</h3>
                <p>Sintaxis, operadores, comandos, gráficas y Matplotlib.</p>
                <span class="tarjeta-pie">Abrir módulo →</span>
            </a>

            <a class="tarjeta destacada" href="<?= url('pages/python/analisis-datos.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">📊</span>
                <h3>Análisis climático</h3>
                <p>Descarga un CSV real, procésalo con pandas y exporta un reporte en PDF.</p>
                <span class="tarjeta-pie">Abrir laboratorio →</span>
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
                <p>Usa Python, pandas y Matplotlib para convertir un CSV en un reporte visual.</p>
                <a class="boton boton-secundario" href="<?= url('pages/python/analisis-datos.php') ?>">Ir al análisis</a>
            </li>
        </ol>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
