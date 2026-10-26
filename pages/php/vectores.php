<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Vectores en PHP';
$descripcion = 'Arrays indexados, asociativos y multidimensionales con ejemplos ejecutables.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

// Demo 1: notas fijas
$notas = [4.5, 3.2, 5.0, 2.8, 4.0];

// Demo 2: promedio calculado por el usuario
$notasUsuario = [];
$promedio = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notas'])) {
    $entrada = explode(',', (string) $_POST['notas']);

    foreach ($entrada as $valor) {
        $valor = trim($valor);
        if ($valor === '') {
            continue;
        }

        if (!is_numeric($valor) || (float) $valor < 0 || (float) $valor > 5) {
            $error = 'Cada nota debe ser un número entre 0.0 y 5.0, separado por comas.';
            $notasUsuario = [];
            break;
        }

        $notasUsuario[] = (float) $valor;
    }

    if ($error === '' && count($notasUsuario) === 0) {
        $error = 'Escribe al menos una nota para calcular el promedio.';
    }

    if ($error === '') {
        $promedio = array_sum($notasUsuario) / count($notasUsuario);
    }
}

$estudiantes = [
    ['nombre' => 'Ana', 'nota' => 4.6],
    ['nombre' => 'Carlos', 'nota' => 3.4],
    ['nombre' => 'Melany', 'nota' => 5.0],
];
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de PHP · 05</span>
        <h1>Vectores: muchos valores, un solo nombre</h1>
        <p>
            Un vector (o <em>array</em>) guarda varios valores dentro de una misma variable.
            PHP permite vectores indexados, asociativos y multidimensionales, y trae funciones
            listas para recorrerlos, sumarlos y ordenarlos.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/php/sesiones.php') ?>">Siguiente: sesiones</a>
            <a class="boton boton-secundario" href="<?= url('pages/php/ciclos.php') ?>">Volver a ciclos</a>
        </div>
    </header>

    <section class="bloque">
        <h2>1. Vector indexado</h2>
        <p>
            Cada elemento ocupa una posición numérica que empieza en <code>0</code>.
            Es la forma más directa de guardar una lista.
        </p>

        <pre><code>&lt;?php
$frutas = ["Manzana", "Pera", "Uva"];

echo $frutas[0]; // Manzana
echo $frutas[2]; // Uva
echo count($frutas); // 3
?&gt;</code></pre>

        <div class="demo-panel">
            <h3>Recorrido del vector</h3>
            <ul class="lista-caracteristicas">
                <?php foreach ($frutas = ['Manzana', 'Pera', 'Uva', 'Mango'] as $indice => $fruta): ?>
                    <li><code>frutas[<?= e($indice) ?>]</code> → <strong><?= e($fruta) ?></strong></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="bloque">
        <h2>2. Vector asociativo</h2>
        <p>
            En lugar de posiciones numéricas, cada valor tiene una clave con nombre.
            Es ideal para representar registros.
        </p>

        <pre><code>&lt;?php
$persona = [
    "nombre" =&gt; "Ana",
    "edad"   =&gt; 25,
    "correo" =&gt; "ana@ejemplo.com",
];

echo $persona["nombre"];
?&gt;</code></pre>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $persona = ['nombre' => 'Ana', 'edad' => 25, 'correo' => 'ana@ejemplo.com'];
                    foreach ($persona as $clave => $valor):
                    ?>
                        <tr>
                            <td><code><?= e($clave) ?></code></td>
                            <td><?= e($valor) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="bloque">
        <h2>3. Vectores multidimensionales</h2>
        <p>Un vector puede contener otros vectores. Así se representan tablas o listas de registros.</p>

        <pre><code>&lt;?php
$estudiantes = [
    ["nombre" =&gt; "Ana",    "nota" =&gt; 4.6],
    ["nombre" =&gt; "Carlos", "nota" =&gt; 3.4],
];

foreach ($estudiantes as $estudiante) {
    echo $estudiante["nombre"] . ": " . $estudiante["nota"];
}
?&gt;</code></pre>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Estudiante</th>
                        <th>Nota</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $i => $estudiante): ?>
                        <tr>
                            <td><?= e($i + 1) ?></td>
                            <td><?= e($estudiante['nombre']) ?></td>
                            <td><?= e(number_format($estudiante['nota'], 1, ',', '.')) ?></td>
                            <td>
                                <?php if ($estudiante['nota'] >= 3.0): ?>
                                    <span class="badge-pill verde">Aprueba</span>
                                <?php else: ?>
                                    <span class="badge-pill naranja">Refuerzo</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="bloque">
        <h2>4. Ejemplo en vivo: promedio de notas</h2>
        <p>
            Estas notas están guardadas en un vector. PHP suma sus valores con
            <code>array_sum()</code> y divide entre <code>count()</code>.
        </p>

        <div class="grid-cards">
            <article class="tarjeta">
                <h3>Notas registradas</h3>
                <div class="demo-panel">
                    <?php foreach ($notas as $i => $nota): ?>
                        <span class="badge-pill">Nota <?= e($i + 1) ?>: <?= e(number_format($nota, 1, ',', '.')) ?></span>
                    <?php endforeach; ?>
                </div>
            </article>

            <article class="tarjeta">
                <h3>Resultado</h3>
                <p>Suma total: <strong><?= e(number_format(array_sum($notas), 1, ',', '.')) ?></strong></p>
                <p>Promedio: <strong><?= e(number_format(array_sum($notas) / count($notas), 2, ',', '.')) ?></strong></p>
                <p>Nota máxima: <strong><?= e(number_format(max($notas), 1, ',', '.')) ?></strong></p>
            </article>
        </div>
    </section>

    <section class="bloque">
        <h2>5. Calcula tu propio promedio</h2>
        <p>Escribe las notas separadas por comas. El cálculo se ejecuta en el servidor.</p>

        <form class="calculadora" action="<?= url('pages/php/vectores.php') ?>" method="POST">
            <div class="login-campo">
                <label for="notas">Notas (0.0 a 5.0)</label>
                <input type="text" id="notas" name="notas" placeholder="Ejemplo: 4.5, 3.2, 5.0, 2.8"
                    value="<?= e($_POST['notas'] ?? '') ?>" required>
            </div>
            <div class="calc-acciones">
                <button type="submit">Calcular promedio</button>
            </div>
        </form>

        <?php if ($error !== ''): ?>
            <div class="alerta alerta-error" role="alert"><?= e($error) ?></div>
        <?php elseif ($promedio !== null): ?>
            <div class="calc-resultado" aria-live="polite">
                <span>
                    <?= e(count($notasUsuario)) ?> notas ·
                    suma <?= e(number_format(array_sum($notasUsuario), 1, ',', '.')) ?> ·
                    máxima <?= e(number_format(max($notasUsuario), 1, ',', '.')) ?>
                </span>
                <strong><?= e(number_format($promedio, 2, ',', '.')) ?></strong>
            </div>
        <?php endif; ?>
    </section>

    <section class="bloque">
        <h2>Funciones útiles para vectores</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Función</th>
                        <th>Qué hace</th>
                        <th>Ejemplo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>count()</code></td>
                        <td>Cuenta los elementos.</td>
                        <td><code>count($frutas)</code></td>
                    </tr>
                    <tr>
                        <td><code>array_sum()</code></td>
                        <td>Suma todos los valores numéricos.</td>
                        <td><code>array_sum($notas)</code></td>
                    </tr>
                    <tr>
                        <td><code>sort()</code></td>
                        <td>Ordena de menor a mayor.</td>
                        <td><code>sort($notas)</code></td>
                    </tr>
                    <tr>
                        <td><code>in_array()</code></td>
                        <td>Comprueba si un valor existe.</td>
                        <td><code>in_array("Uva", $frutas)</code></td>
                    </tr>
                    <tr>
                        <td><code>implode()</code></td>
                        <td>Une los elementos en un texto.</td>
                        <td><code>implode(", ", $frutas)</code></td>
                    </tr>
                    <tr>
                        <td><code>array_keys()</code></td>
                        <td>Devuelve las claves del vector.</td>
                        <td><code>array_keys($persona)</code></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
