<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = '¿Qué es PHP?';
$descripcion = 'Introducción a PHP, sus características y conceptos fundamentales.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de PHP · 01</span>
        <h1>PHP: el lenguaje del servidor</h1>
        <p>
            PHP (<em>PHP: Hypertext Preprocessor</em>) es un lenguaje de programación de código abierto
            diseñado para el desarrollo web. Se ejecuta en el servidor y genera HTML dinámico
            antes de enviarlo al navegador.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/php/variables.php') ?>">Continuar con variables</a>
            <a class="boton boton-secundario" href="<?= url('inicio.php') ?>">Volver al inicio</a>
        </div>
    </header>

    <section class="bloque">
        <h2>¿Qué es PHP?</h2>
        <p>
            PHP es un lenguaje de scripting que se ejecuta del lado del servidor. Cuando un usuario
            solicita una página <code>.php</code>, el servidor procesa el código, genera HTML y lo envía
            al navegador. El usuario nunca ve el código PHP original, solo el resultado final.
        </p>

        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🐘</span>
                <h3>Lenguaje del servidor</h3>
                <p>Se ejecuta en el backend, no en el navegador del usuario.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">⚡</span>
                <h3>Rápido y dinámico</h3>
                <p>Genera contenido HTML en tiempo real según la petición.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🔓</span>
                <h3>Código abierto</h3>
                <p>Gratuito, con una comunidad enorme y miles de librerías.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🌐</span>
                <h3>Multiplataforma</h3>
                <p>Compatible con Windows, Linux y macOS sin cambios.</p>
            </article>
        </div>
    </section>

    <section class="bloque">
        <h2>Características principales</h2>
        <ul class="lista-caracteristicas">
            <li>Sintaxis sencilla y fácil de aprender.</li>
            <li>Amplia integración con bases de datos como MySQL y PostgreSQL.</li>
            <li>Compatible con los servidores web más populares: Apache y Nginx.</li>
            <li>Soporte para programación orientada a objetos.</li>
            <li>Gran cantidad de frameworks: Laravel, Symfony y CodeIgniter.</li>
        </ul>
    </section>

    <section class="bloque">
        <span class="section-kicker">Conceptos fundamentales</span>
        <h2>Los bloques de todo programa PHP</h2>

        <div class="accordion" id="conceptosPhp">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#phpVariables" aria-expanded="true" aria-controls="phpVariables">
                        1. Variables
                    </button>
                </h2>
                <div id="phpVariables" class="accordion-collapse collapse show" data-bs-parent="#conceptosPhp">
                    <div class="accordion-body">
                        <p>En PHP las variables empiezan con el símbolo <code>$</code> y no requieren declaración de tipo.</p>
                        <pre><code>&lt;?php
$nombre = "Ana";
$edad = 25;
$precio = 19.99;
?&gt;</code></pre>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#phpTipos" aria-expanded="false" aria-controls="phpTipos">
                        2. Tipos de datos
                    </button>
                </h2>
                <div id="phpTipos" class="accordion-collapse collapse" data-bs-parent="#conceptosPhp">
                    <div class="accordion-body">
                        <p>PHP maneja varios tipos: <code>string</code>, <code>int</code>, <code>float</code>,
                            <code>bool</code>, <code>array</code>, <code>object</code> y <code>null</code>.</p>
                        <pre><code>&lt;?php
$texto   = "Hola";       // string
$numero  = 42;           // int
$decimal = 3.14;         // float
$activo  = true;         // bool
$lista   = [1, 2, 3];    // array
?&gt;</code></pre>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#phpCondicionales" aria-expanded="false" aria-controls="phpCondicionales">
                        3. Condicionales
                    </button>
                </h2>
                <div id="phpCondicionales" class="accordion-collapse collapse" data-bs-parent="#conceptosPhp">
                    <div class="accordion-body">
                        <p>Permiten ejecutar bloques de código según una condición.</p>
                        <pre><code>&lt;?php
$edad = 18;

if ($edad &gt;= 18) {
    echo "Eres mayor de edad";
} else {
    echo "Eres menor de edad";
}
?&gt;</code></pre>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#phpBucles" aria-expanded="false" aria-controls="phpBucles">
                        4. Bucles
                    </button>
                </h2>
                <div id="phpBucles" class="accordion-collapse collapse" data-bs-parent="#conceptosPhp">
                    <div class="accordion-body">
                        <p>Repiten un bloque de código. Los más comunes son <code>for</code>, <code>while</code> y
                            <code>foreach</code>.</p>
                        <pre><code>&lt;?php
$frutas = ["Manzana", "Pera", "Uva"];

foreach ($frutas as $fruta) {
    echo $fruta . "&lt;br&gt;";
}
?&gt;</code></pre>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#phpFunciones" aria-expanded="false" aria-controls="phpFunciones">
                        5. Funciones
                    </button>
                </h2>
                <div id="phpFunciones" class="accordion-collapse collapse" data-bs-parent="#conceptosPhp">
                    <div class="accordion-body">
                        <p>Bloques reutilizables de código que reciben parámetros y pueden devolver valores.</p>
                        <pre><code>&lt;?php
function saludar($nombre) {
    return "Hola, " . $nombre;
}

echo saludar("Carlos");
?&gt;</code></pre>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#phpSuperglobales" aria-expanded="false" aria-controls="phpSuperglobales">
                        6. Superglobales
                    </button>
                </h2>
                <div id="phpSuperglobales" class="accordion-collapse collapse" data-bs-parent="#conceptosPhp">
                    <div class="accordion-body">
                        <p>Variables predefinidas accesibles desde cualquier parte del script:</p>
                        <ul class="lista-caracteristicas">
                            <li><code>$_GET</code> – Datos enviados por URL.</li>
                            <li><code>$_POST</code> – Datos enviados por formulario.</li>
                            <li><code>$_SESSION</code> – Datos persistentes del usuario.</li>
                            <li><code>$_COOKIE</code> – Datos almacenados en el navegador.</li>
                            <li><code>$_SERVER</code> – Información del servidor.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bloque">
        <h2>Ejemplo completo</h2>
        <p>Un pequeño script que combina varios conceptos:</p>
        <pre><code>&lt;?php
$usuario = "Ana";
$carrito = ["Libro", "Cuaderno", "Lápiz"];
$total = 0;

foreach ($carrito as $producto) {
    $total += 5;
    echo "Producto: $producto &lt;br&gt;";
}

echo "Hola $usuario, tu total es: $$total";
?&gt;</code></pre>

        <div class="nota">
            <strong>Recuerda:</strong> todo el código PHP se escribe entre las etiquetas
            <code>&lt;?php ... ?&gt;</code> y se ejecuta en el servidor antes de enviar la respuesta.
        </div>
    </section>

    <section class="bloque">
        <h2>Comprobación en vivo</h2>
        <p>Esta página también es PHP. Si puedes leer esto, el servidor está ejecutando el lenguaje:</p>
        <div class="demo-panel">
            <h3>Datos generados por el servidor</h3>
            <ul class="lista-caracteristicas">
                <li>Versión de PHP: <strong><?= e(PHP_VERSION) ?></strong></li>
                <li>Fecha y hora del servidor: <strong><?= e(date('d/m/Y H:i:s')) ?></strong></li>
                <li>Servidor web: <strong><?= e($_SERVER['SERVER_SOFTWARE'] ?? 'No disponible') ?></strong></li>
                <li>Usuario autenticado: <strong><?= e($_SESSION['nombre'] ?? '') ?></strong></li>
            </ul>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
