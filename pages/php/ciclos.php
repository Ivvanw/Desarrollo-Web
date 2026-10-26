<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Ciclos en PHP';
$descripcion = 'While, do-while, for y foreach con ejemplos ejecutables.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

$numeroTabla = isset($_GET['numero']) && $_GET['numero'] !== '' ? (int) $_GET['numero'] : null;
$mostrarTodas = isset($_GET['todo']) && $numeroTabla !== null;
$frutas = ['Manzana', 'Pera', 'Uva', 'Mango', 'Fresa'];
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de PHP · 04</span>
        <h1>Ciclos: repetir sin repetir código</h1>
        <p>
            Los ciclos ejecutan un bloque varias veces. PHP ofrece <code>while</code>,
            <code>do...while</code>, <code>for</code> y <code>foreach</code>.
            Cada uno brilla en un escenario distinto.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/php/vectores.php') ?>">Siguiente: vectores</a>
            <a class="boton boton-secundario" href="<?= url('pages/php/condicionales.php') ?>">Volver a condicionales</a>
        </div>
    </header>

    <section class="bloque">
        <h2>1. While y do...while</h2>
        <p>
            <code>while</code> evalúa la condición antes de cada vuelta; si es falsa desde el inicio,
            el bloque no se ejecuta. <code>do...while</code> evalúa al final, así que siempre corre al menos una vez.
        </p>

        <div class="grid-cards">
            <article class="tarjeta">
                <h3>while</h3>
                <p>Repite mientras la condición sea verdadera.</p>
                <div class="demo-panel">
                    <?php
                    $n = 1;
                    while ($n <= 6) {
                        echo '<span class="badge-pill">Buen día ' . $n . '</span> ';
                        $n++;
                    }
                    ?>
                </div>
            </article>

            <article class="tarjeta">
                <h3>do...while</h3>
                <p>Se ejecuta al menos una vez y luego comprueba la condición.</p>
                <div class="demo-panel">
                    <?php
                    $k = 1;
                    do {
                        echo '<span class="badge-pill naranja">Número ' . $k . '</span> ';
                        $k++;
                    } while ($k <= 7);
                    ?>
                </div>
            </article>
        </div>
    </section>

    <section class="bloque">
        <h2>2. For: tablas de multiplicar</h2>
        <p>El ciclo <code>for</code> se usa cuando sabemos cuántas iteraciones necesitamos.</p>

        <form action="<?= url('pages/php/ciclos.php') ?>" method="GET" class="calc-campos">
            <div class="login-campo">
                <label for="numero">Número para la tabla</label>
                <input type="number" id="numero" name="numero" min="1" max="20"
                    value="<?= e($numeroTabla ?? '') ?>" placeholder="Ejemplo: 7" required>
            </div>
            <div class="calc-acciones">
                <button type="submit" name="enviar" value="1">Generar tabla</button>
                <button type="submit" name="todo" value="1" class="boton boton-secundario">Todas hasta el número</button>
            </div>
        </form>

        <?php if ($numeroTabla !== null && $numeroTabla > 0 && $numeroTabla <= 20): ?>
            <div class="tablas-grid">
                <?php
                $limite = $mostrarTodas ? $numeroTabla : $numeroTabla;
                $desde = $mostrarTodas ? 1 : $numeroTabla;

                for ($tabla = $desde; $tabla <= $limite; $tabla++):
                ?>
                    <div class="tabla-multiplicar">
                        <h3>Tabla del <?= e($tabla) ?></h3>
                        <table>
                            <tbody>
                                <?php for ($fila = 1; $fila <= 10; $fila++): ?>
                                    <tr>
                                        <td><?= e($fila) ?></td>
                                        <td class="signo">×</td>
                                        <td><?= e($tabla) ?></td>
                                        <td class="signo">=</td>
                                        <td><strong><?= e($fila * $tabla) ?></strong></td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endfor; ?>
            </div>
        <?php elseif ($numeroTabla !== null): ?>
            <div class="alerta alerta-error">Escribe un número entre 1 y 20.</div>
        <?php endif; ?>
    </section>

    <section class="bloque">
        <h2>3. Foreach: recorrer arreglos</h2>
        <p><code>foreach</code> es la forma más cómoda de recorrer un vector o un objeto.</p>

        <pre><code>&lt;?php
$frutas = ["Manzana", "Pera", "Uva"];

foreach ($frutas as $fruta) {
    echo $fruta . "&lt;br&gt;";
}
?&gt;</code></pre>

        <div class="demo-panel">
            <h3>Lista generada con foreach</h3>
            <ul class="lista-caracteristicas">
                <?php foreach ($frutas as $indice => $fruta): ?>
                    <li><?= e($indice + 1) ?>. <?= e($fruta) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="bloque">
        <h2>Resumen de los ciclos</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Ciclo</th>
                        <th>Cuándo usarlo</th>
                        <th>Comprueba la condición</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>while</code></td>
                        <td>No sabemos cuántas vueltas hará.</td>
                        <td>Antes de cada iteración.</td>
                    </tr>
                    <tr>
                        <td><code>do...while</code></td>
                        <td>Debe ejecutarse al menos una vez.</td>
                        <td>Después de cada iteración.</td>
                    </tr>
                    <tr>
                        <td><code>for</code></td>
                        <td>Sabemos el número exacto de repeticiones.</td>
                        <td>Antes de cada iteración.</td>
                    </tr>
                    <tr>
                        <td><code>foreach</code></td>
                        <td>Recorremos todos los elementos de un arreglo.</td>
                        <td>Por cada elemento.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
