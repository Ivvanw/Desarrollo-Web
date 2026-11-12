<?php
/**
 * Acceso al manual de Python.
 *
 * El tutor de PHP es libre; el manual de Python exige sesión. Si alguien escribe
 * a mano una ruta de manual-python/ sin haber iniciado sesión, llega aquí y,
 * tras el login, vuelve a la página que pidió.
 */
require_once __DIR__ . '/../config/auth.php';

if (estaAutenticado()) {
    header('Location: ' . url('manual-python/index.php'));
    exit();
}

$error = '';
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim((string) ($_POST['usuario'] ?? ''));
    $clave = (string) ($_POST['clave'] ?? '');
    $token = $_POST['csrf'] ?? null;

    if (!csrfValido($token)) {
        $error = 'La sesión del formulario expiró. Inténtalo de nuevo.';
    } elseif ($usuario === '' || $clave === '') {
        $error = 'Debes ingresar usuario y contraseña. No se permite el acceso con los campos vacíos.';
    } elseif (!credencialesValidas($usuario, $clave)) {
        $error = 'Usuario o contraseña incorrectos.';
    } else {
        $destino = paginaPendiente();
        iniciarSesionUsuario($usuario);
        header('Location: ' . $destino);
        exit();
    }
}

if (!empty($_SESSION['flash_error'])) {
    $error = $_SESSION['flash_error'];
    unset($_SESSION['flash_error']);
}

$titulo = 'Acceso al manual de Python';
$descripcion = 'Acceso privado al manual de Python y al laboratorio de análisis de datos.';
$bodyClass = 'login-page';
require __DIR__ . '/../includes/head.php';
?>

<main class="login-shell">
    <span class="login-logo" aria-hidden="true"><?= icono('python', 30) ?></span>
    <p class="login-etiqueta">Área privada</p>
    <h1 class="login-titulo">Manual de Python</h1>

    <?php if ($error !== ''): ?>
        <div class="alerta alerta-error" role="alert">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <section class="login-panel" aria-label="Formulario de acceso">
        <form class="login-form" action="<?= url('manual-python/login.php') ?>" method="POST" autocomplete="on" novalidate>
            <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">

            <div class="login-campo">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" value="<?= e($usuario) ?>"
                    autocomplete="username" required autofocus>
            </div>

            <div class="login-campo">
                <label for="clave">Contraseña</label>
                <input type="password" id="clave" name="clave" autocomplete="current-password" required>
            </div>

            <button type="submit">Entrar</button>
        </form>
    </section>

    <div class="login-caja">
        <p class="login-pista">
            Cuenta de demostración: <code>admin</code> / <code>123</code>
        </p>
    </div>

    <section class="login-info">
        <p>El manual de Python incluye:</p>
        <ul class="login-lista">
            <li>Conceptos, variables, operadores y comandos de Python</li>
            <li>Gráficas con Chart.js y galería de Matplotlib</li>
            <li>Análisis de sismos reales con pandas</li>
            <li>Exportación del reporte a PDF</li>
        </ul>
    </section>

    <p class="login-pie">
        <a href="<?= url('index.php') ?>">← Volver al tutor de PHP</a><br>
        El manual de Python usa una sesión para recordar tu acceso.
    </p>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
<script src="<?= url('assets/js/app.js') ?>"></script>
</body>

</html>
