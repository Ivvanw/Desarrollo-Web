<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Conceptos de Python';
$descripcion = 'Qué es Python, cómo se ejecuta y por qué es tan usado.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

$caracteristicas = [
    ['icono' => '📖', 'titulo' => 'Sintaxis clara', 'texto' => 'Se parece al inglés y usa indentación obligatoria en lugar de llaves.'],
    ['icono' => '⚡', 'titulo' => 'Interpretado', 'texto' => 'El código se ejecuta línea por línea, sin compilación previa.'],
    ['icono' => '🎯', 'titulo' => 'Tipado dinámico', 'texto' => 'El tipo se detecta al asignar el valor; no hay que declararlo.'],
    ['icono' => '🧩', 'titulo' => 'Multiparadigma', 'texto' => 'Permite programación estructurada, orientada a objetos y funcional.'],
    ['icono' => '📚', 'titulo' => 'Biblioteca estándar', 'texto' => 'Trae módulos para archivos, redes, matemáticas y texto.'],
    ['icono' => '🌍', 'titulo' => 'Multiplataforma', 'texto' => 'Funciona igual en Windows, macOS y Linux.'],
];

$pasosEjecucion = [
    ['titulo' => 'Escribe el código', 'texto' => 'Abre VS Code o cualquier editor y crea tus instrucciones.'],
    ['titulo' => 'Guarda el archivo', 'texto' => 'Usa un nombre descriptivo y la extensión <code>.py</code>, por ejemplo <code>programa.py</code>.'],
    ['titulo' => 'Abre la terminal', 'texto' => 'En Windows usa CMD o PowerShell; en macOS y Linux, la Terminal.'],
    ['titulo' => 'Navega a la carpeta', 'texto' => 'Usa <code>cd</code> seguido de la ruta donde guardaste el archivo.'],
    ['titulo' => 'Ejecuta el programa', 'texto' => 'Escribe <code>python programa.py</code> o <code>python3 programa.py</code>.'],
];
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de Python · 01</span>
        <h1>Python: código legible, resultados rápidos</h1>
        <p>
            Python es un lenguaje de programación interpretado, de tipado dinámico y con una
            sintaxis pensada para leerse. Hoy se usa en desarrollo web, automatización, ciencia
            de datos e inteligencia artificial.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/python/variables.php') ?>">Continuar con variables</a>
            <a class="boton boton-secundario" href="<?= url('pages/php/base-datos.php') ?>">Volver a PHP</a>
        </div>
    </header>

    <section class="bloque">
        <h2>¿Qué es Python?</h2>
        <p>
            Es un lenguaje creado por Guido van Rossum en 1991. Su filosofía se resume en una idea:
            el código se escribe una vez y se lee muchas más. La indentación no es decorativa:
            define los bloques del programa.
        </p>

        <div class="grid-cards">
            <?php foreach ($caracteristicas as $caracteristica): ?>
                <article class="tarjeta">
                    <span class="tarjeta-icono" aria-hidden="true"><?= $caracteristica['icono'] ?></span>
                    <h3><?= e($caracteristica['titulo']) ?></h3>
                    <p><?= e($caracteristica['texto']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="bloque">
        <h2>¿Cómo ejecuta Python tu código?</h2>
        <ol class="pasos">
            <?php foreach ($pasosEjecucion as $i => $paso): ?>
                <li class="paso">
                    <span class="paso-numero"><?= e($i + 1) ?></span>
                    <h3><?= e($paso['titulo']) ?></h3>
                    <p><?= $paso['texto'] ?></p>
                </li>
            <?php endforeach; ?>
        </ol>

        <div class="info-box">
            <strong>Diferencia clave con PHP:</strong> PHP se ejecuta en el servidor web para generar HTML.
            Python se ejecuta como un programa independiente; en este tutor lo usamos para procesar datos
            y generar gráficas y reportes.
        </div>
    </section>

    <section class="bloque">
        <h2>Primer programa</h2>
        <p>
            El ejemplo define dos variables y usa un condicional. Observa los dos puntos al final de
            <code>if</code> y la indentación de las instrucciones que dependen de él.
        </p>

        <pre><code># 1. Definición de variables (tipado dinámico)
nombre = "Carlos"
edad = 20

# 2. Condicional con indentación obligatoria
if edad &gt;= 18:
    print(f"Hola {nombre}, eres mayor de edad y puedes pasar.")
else:
    print(f"Hola {nombre}, eres menor de edad.")</code></pre>

        <div class="demo-panel">
            <h3>Salida esperada</h3>
            <pre><code>Hola Carlos, eres mayor de edad y puedes pasar.</code></pre>
            <p class="small-note">
                La letra <code>f</code> antes de las comillas permite insertar variables dentro del texto
                con llaves: <code>{nombre}</code>.
            </p>
        </div>
    </section>

    <section class="bloque">
        <h2>¿Dónde se usa Python?</h2>
        <div class="technology-grid">
            <article class="technology-card">
                <h3>Desarrollo web</h3>
                <p>Django, Flask y FastAPI para construir servicios y APIs.</p>
                <span>Backend</span>
            </article>
            <article class="technology-card">
                <h3>Ciencia de datos</h3>
                <p>pandas, NumPy y Matplotlib para analizar y visualizar información.</p>
                <span>Datos</span>
            </article>
            <article class="technology-card">
                <h3>Inteligencia artificial</h3>
                <p>PyTorch, scikit-learn y TensorFlow para modelos y experimentos.</p>
                <span>IA</span>
            </article>
            <article class="technology-card">
                <h3>Automatización</h3>
                <p>Scripts para archivos, reportes, correos y tareas repetitivas.</p>
                <span>Productividad</span>
            </article>
        </div>
    </section>

    <section class="bloque">
        <h2>Ruta del manual</h2>
        <div class="dashboard-grid">
            <a class="tarjeta" href="<?= url('pages/python/variables.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">📦</span>
                <h3>Variables</h3>
                <p>Textos, números, booleanos y colecciones.</p>
                <span class="tarjeta-pie">Abrir →</span>
            </a>
            <a class="tarjeta" href="<?= url('pages/python/operadores.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">➗</span>
                <h3>Operadores</h3>
                <p>Aritmética, comparación, lógica y asignación.</p>
                <span class="tarjeta-pie">Abrir →</span>
            </a>
            <a class="tarjeta" href="<?= url('pages/python/comandos.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">⌨️</span>
                <h3>Comandos</h3>
                <p>Entrada, salida, ciclos, funciones y casting.</p>
                <span class="tarjeta-pie">Abrir →</span>
            </a>
            <a class="tarjeta" href="<?= url('pages/python/graficas.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">📈</span>
                <h3>Gráficas</h3>
                <p>Barras, líneas y dona con Chart.js.</p>
                <span class="tarjeta-pie">Abrir →</span>
            </a>
            <a class="tarjeta" href="<?= url('pages/python/matplotlib.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">🐍</span>
                <h3>CSV y Matplotlib</h3>
                <p>Del archivo de ventas a las gráficas de Python.</p>
                <span class="tarjeta-pie">Abrir →</span>
            </a>
            <a class="tarjeta destacada" href="<?= url('pages/python/analisis-datos.php') ?>">
                <span class="tarjeta-icono" aria-hidden="true">🌦️</span>
                <h3>Análisis climático</h3>
                <p>Descarga, procesa y exporta un reporte real.</p>
                <span class="tarjeta-pie">Abrir laboratorio →</span>
            </a>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
