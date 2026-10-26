<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Variables en PHP';
$descripcion = 'Variables, tipos de datos y operaciones básicas en PHP.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

$nombre = 'Juan Andres Pulecio';
$edad = 19;
$soltero = true;
$precio = 19.99;
$frutas = ['Manzana', 'Pera', 'Uva'];
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de PHP · 02</span>
        <h1>Variables y tipos de datos</h1>
        <p>
            Una variable es un contenedor con nombre que guarda un valor en memoria. En PHP
            comienza con <code>$</code> y su tipo se detecta automáticamente al asignarle un valor.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/php/condicionales.php') ?>">Siguiente: condicionales</a>
            <a class="boton boton-secundario" href="<?= url('pages/php/index.php') ?>">Volver a introducción</a>
        </div>
    </header>

    <section class="bloque">
        <h2>Resultado en pantalla</h2>
        <p>Estos valores los está calculando PHP en el servidor antes de enviar la página:</p>

        <div class="demo-panel">
            <h3>Variables de ejemplo</h3>
            <ul class="lista-caracteristicas">
                <li>Nombre: <strong><?= e($nombre) ?></strong></li>
                <li>Edad: <strong><?= e($edad) ?></strong> años</li>
                <li>Precio del producto: <strong>$<?= e(number_format($precio, 2, ',', '.')) ?></strong></li>
                <li>Estado civil: <strong><?= $soltero ? 'Soltero' : 'Con pareja' ?></strong></li>
                <li>Lista de frutas: <strong><?= e(implode(', ', $frutas)) ?></strong></li>
            </ul>
            <p class="small-note">Cada valor se imprime con <code>echo</code> y se escapa con <code>htmlspecialchars</code> por seguridad.</p>
        </div>
    </section>

    <section class="bloque">
        <h2>Código PHP utilizado</h2>
        <pre><code>&lt;?php
$nombre = "Juan Andres Pulecio";
$edad = 19;
$precio = 19.99;
$soltero = true;
$frutas = ["Manzana", "Pera", "Uva"];

echo "Nombre: " . $nombre;
echo "Edad: " . $edad;
echo "Precio: $" . $precio;
echo "Estado civil: " . ($soltero ? "Soltero" : "Con pareja");
?&gt;</code></pre>

        <h3>Reglas importantes</h3>
        <ul class="lista-caracteristicas">
            <li>El nombre debe empezar con <code>$</code> seguido de una letra o guion bajo.</li>
            <li>No puede empezar con un número ni contener espacios.</li>
            <li>PHP distingue mayúsculas y minúsculas en los nombres de variables.</li>
            <li>No es necesario declarar el tipo: se asigna al crear la variable.</li>
        </ul>
    </section>

    <section class="bloque">
        <h2>Tipos de datos comunes</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Ejemplo</th>
                        <th>Uso</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>string</code></td>
                        <td><code>"Hola mundo"</code></td>
                        <td>Texto y cadenas de caracteres.</td>
                    </tr>
                    <tr>
                        <td><code>int</code></td>
                        <td><code>42</code></td>
                        <td>Números enteros.</td>
                    </tr>
                    <tr>
                        <td><code>float</code></td>
                        <td><code>3.14</code></td>
                        <td>Números con decimales.</td>
                    </tr>
                    <tr>
                        <td><code>bool</code></td>
                        <td><code>true / false</code></td>
                        <td>Valores lógicos.</td>
                    </tr>
                    <tr>
                        <td><code>array</code></td>
                        <td><code>[1, 2, 3]</code></td>
                        <td>Colecciones de valores.</td>
                    </tr>
                    <tr>
                        <td><code>null</code></td>
                        <td><code>null</code></td>
                        <td>Ausencia de valor.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="bloque">
        <h2>Concatenación e interpolación</h2>
        <p>Existen dos formas de unir texto y variables:</p>
        <pre><code>&lt;?php
$nombre = "Ana";

// Concatenación con punto
echo "Hola " . $nombre;

// Interpolación dentro de comillas dobles
echo "Hola $nombre";
?&gt;</code></pre>

        <div class="info-box">
            <strong>Buena práctica:</strong> escapa siempre los datos que vienen del usuario antes de imprimirlos.
            En este proyecto usamos <code>htmlspecialchars()</code> para evitar inyección de HTML.
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
