<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Condicionales en PHP';
$descripcion = 'Calculadora con switch e if/else para practicar condicionales en PHP.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

$numero1 = isset($_POST['numero1']) ? (float) $_POST['numero1'] : 5;
$numero2 = isset($_POST['numero2']) ? (float) $_POST['numero2'] : 2;
$operacion = $_POST['operacion'] ?? '';
$resultado = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $operacion !== '') {
    switch ($operacion) {
        case '+':
            $resultado = $numero1 + $numero2;
            $etiqueta = 'Suma';
            break;
        case '-':
            $resultado = $numero1 - $numero2;
            $etiqueta = 'Resta';
            break;
        case '*':
            $resultado = $numero1 * $numero2;
            $etiqueta = 'Multiplicación';
            break;
        case '/':
            if ($numero2 != 0) {
                $resultado = $numero1 / $numero2;
                $etiqueta = 'División';
            } else {
                $error = 'No se puede dividir entre cero.';
            }
            break;
        case 'R':
            if ($numero1 >= 0) {
                $resultado = sqrt($numero1);
                $etiqueta = 'Raíz cuadrada';
            } else {
                $error = 'La raíz cuadrada requiere un número positivo.';
            }
            break;
        case 'S':
            $resultado = sin($numero1);
            $etiqueta = 'Seno';
            break;
        case 'T':
            $resultado = tan($numero1);
            $etiqueta = 'Tangente';
            break;
        case 'L':
            if ($numero1 > 0) {
                $resultado = log($numero1);
                $etiqueta = 'Logaritmo natural';
            } else {
                $error = 'El logaritmo requiere un número positivo.';
            }
            break;
        default:
            $error = 'Operación no válida.';
    }
}
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de PHP · 03</span>
        <h1>Condicionales: calculadora criolla</h1>
        <p>
            Un condicional decide qué camino toma el programa. Esta calculadora usa
            <code>switch</code> para elegir la operación y <code>if / else</code> para validar
            casos especiales como la división entre cero.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/php/ciclos.php') ?>">Siguiente: ciclos</a>
            <a class="boton boton-secundario" href="<?= url('pages/php/variables.php') ?>">Volver a variables</a>
        </div>
    </header>

    <section class="bloque">
        <h2>Calculadora interactiva</h2>
        <p>Escribe dos números y presiona una operación. El cálculo se realiza en el servidor con PHP.</p>

        <form class="calculadora" action="<?= url('pages/php/condicionales.php') ?>" method="POST">
            <div class="calc-campos">
                <div class="login-campo">
                    <label for="numero1">Número 1</label>
                    <input type="number" step="any" id="numero1" name="numero1" value="<?= e($numero1) ?>" required>
                </div>
                <div class="login-campo">
                    <label for="numero2">Número 2</label>
                    <input type="number" step="any" id="numero2" name="numero2" value="<?= e($numero2) ?>" required>
                </div>
            </div>

            <div class="calc-teclado">
                <input type="submit" name="operacion" value="+" aria-label="Sumar">
                <input type="submit" name="operacion" value="-" aria-label="Restar">
                <input type="submit" name="operacion" value="*" aria-label="Multiplicar">
                <input type="submit" name="operacion" value="/" aria-label="Dividir">
                <input type="submit" name="operacion" value="R" aria-label="Raíz cuadrada">
                <input type="submit" name="operacion" value="S" aria-label="Seno">
                <input type="submit" name="operacion" value="T" aria-label="Tangente">
                <input type="submit" name="operacion" value="L" aria-label="Logaritmo natural">
            </div>
        </form>

        <?php if ($error !== ''): ?>
            <div class="alerta alerta-error" role="alert"><?= e($error) ?></div>
        <?php elseif ($resultado !== null): ?>
            <div class="calc-resultado" aria-live="polite">
                <span><?= e($etiqueta) ?> de <?= e($numero1) ?><?= in_array($operacion, ['+', '-', '*', '/'], true) ? ' y ' . e($numero2) : '' ?></span>
                <strong><?= e(round($resultado, 6)) ?></strong>
            </div>
        <?php endif; ?>

        <div class="info-box">
            <strong>Teclas:</strong> <code>+</code>, <code>-</code>, <code>*</code> y <code>/</code> son operaciones básicas.
            <code>R</code> calcula la raíz cuadrada, <code>S</code> el seno, <code>T</code> la tangente y
            <code>L</code> el logaritmo natural del primer número.
        </div>
    </section>

    <section class="bloque">
        <h2>¿Cómo funcionan los condicionales aquí?</h2>
        <p>
            La estructura <code>switch</code> evalúa el valor de <code>$operacion</code> (el botón que se presionó)
            y ejecuta el bloque <code>case</code> que coincida. Es una alternativa ordenada a una cadena larga de
            <code>if...elseif...else</code>.
        </p>

        <ul class="lista-caracteristicas">
            <li><strong>switch:</strong> decide qué operación matemática realizar según el botón.</li>
            <li><strong>if / else:</strong> valida errores dentro de los casos de división, raíz y logaritmo.</li>
            <li><strong>break:</strong> detiene la ejecución del switch para no evaluar los demás casos.</li>
            <li><strong>default:</strong> se ejecuta si ninguna opción coincide.</li>
        </ul>

        <h3>Código fuente de la calculadora</h3>
        <pre><code>&lt;?php
if (isset($_POST['operacion'])) {
    $numero1 = $_POST['numero1'];
    $numero2 = $_POST['numero2'];
    $operacion = $_POST['operacion'];
    $rta = 0;

    switch ($operacion) {
        case "+":
            $rta = $numero1 + $numero2;
            echo "&lt;div&gt;Suma: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            break;
        case "-":
            $rta = $numero1 - $numero2;
            echo "&lt;div&gt;Resta: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            break;
        case "*":
            $rta = $numero1 * $numero2;
            echo "&lt;div&gt;Multiplicación: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            break;
        case "/":
            if ($numero2 != 0) {
                $rta = $numero1 / $numero2;
                echo "&lt;div&gt;División: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            } else {
                echo "&lt;div&gt;Error: No se puede dividir entre cero&lt;/div&gt;";
            }
            break;
        case "R":
            if ($numero1 &gt;= 0) {
                $rta = sqrt($numero1);
                echo "&lt;div&gt;Raíz Cuadrada: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            } else {
                echo "&lt;div&gt;Error: La raíz requiere un número positivo&lt;/div&gt;";
            }
            break;
        case "S":
            $rta = sin($numero1);
            echo "&lt;div&gt;Seno: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            break;
        case "T":
            $rta = tan($numero1);
            echo "&lt;div&gt;Tangente: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            break;
        case "L":
            if ($numero1 &gt; 0) {
                $rta = log($numero1);
                echo "&lt;div&gt;Logaritmo: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            } else {
                echo "&lt;div&gt;Error: El logaritmo requiere un número positivo&lt;/div&gt;";
            }
            break;
    }
}
?&gt;</code></pre>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
