<?php
/**
 * Página de acceso al tutor.
 * Es la única página pública del sitio.
 */
require_once __DIR__ . '/config/auth.php';

if (estaAutenticado()) {
    header('Location: ' . url('inicio.php'));
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
        iniciarSesionUsuario($usuario);
        header('Location: ' . url('inicio.php'));
        exit();
    }
}

if (!empty($_SESSION['flash_error'])) {
    $error = $_SESSION['flash_error'];
    unset($_SESSION['flash_error']);
}

$titulo = 'Acceso';
$descripcion = 'Acceso privado al tutor de desarrollo web, PHP y Python.';
$bodyClass = 'login-page';
require __DIR__ . '/includes/head.php';
?>

<main class="login-shell">
    <section class="login-info">
        <span class="login-marca">
            <span class="marca-icono">&lt;/&gt;</span>
            Tutor Web
        </span>

        <h1>Aprende desarrollo web desde la base hasta los datos.</h1>
        <p>
            Un recorrido completo por HTML, CSS, JavaScript, PHP y Python, con ejemplos,
            demos interactivas y un sistema real de análisis de datos climáticos.
        </p>

        <ul class="login-lista">
            <li>Conceptos de arquitectura web y evolución de sistemas</li>
            <li>Manual de PHP con ejemplos ejecutables</li>
            <li>Manual de Python, gráficas y análisis de datos</li>
            <li>Material histórico de HTML y CSS</li>
        </ul>
    </section>

    <section class="login-panel">
        <p class="login-etiqueta">Área privada</p>
        <h2>Iniciar sesión</h2>
        <p>Ingresa tus credenciales para abrir las páginas del tutor.</p>

        <?php if ($error !== ''): ?>
            <div class="alerta alerta-error" role="alert">
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <form class="login-form" action="<?= url('index.php') ?>" method="POST" autocomplete="on" novalidate>
            <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">

            <div class="login-campo">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" value="<?= e($usuario) ?>"
                    autocomplete="username" placeholder="Escribe tu usuario" required autofocus>
            </div>

            <div class="login-campo">
                <label for="clave">Contraseña</label>
                <input type="password" id="clave" name="clave" autocomplete="current-password"
                    placeholder="Escribe tu contraseña" required>
            </div>

            <button type="submit">Entrar al tutor</button>
        </form>

        <p class="login-pista">
            <strong>Cuenta de demostración:</strong><br>
            Usuario: <strong>admin</strong> · Contraseña: <strong>123</strong>
        </p>

        <p class="login-pie">
            Al continuar aceptas que este sitio usa una sesión para recordar tu acceso.
        </p>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
<script src="<?= url('assets/js/app.js') ?>"></script>
</body>

</html>
