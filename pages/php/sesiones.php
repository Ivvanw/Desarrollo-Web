<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Sesiones en PHP';
$descripcion = 'Qué es una sesión, cómo se guarda y cómo se protege en PHP.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

// Demo interactiva: un contador guardado en la sesión del visitante
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrfValido($_POST['csrf'] ?? null)) {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'sumar') {
        $_SESSION['demo_contador'] = (int) ($_SESSION['demo_contador'] ?? 0) + 1;
    } elseif ($accion === 'reiniciar') {
        $_SESSION['demo_contador'] = 0;
    }
}

$contador = (int) ($_SESSION['demo_contador'] ?? 0);
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de PHP · 06</span>
        <h1>Sesiones: recordar al usuario</h1>
        <p>
            HTTP no recuerda nada entre una petición y otra. La sesión resuelve ese problema:
            el servidor guarda datos del visitante y el navegador solo conserva un identificador
            en una cookie. Es la base del inicio de sesión.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/php/base-datos.php') ?>">Siguiente: base de datos</a>
            <a class="boton boton-secundario" href="<?= url('pages/php/vectores.php') ?>">Volver a vectores</a>
        </div>
    </header>

    <section class="bloque">
        <h2>¿Cómo funciona una sesión?</h2>
        <ol class="pasos">
            <li class="paso">
                <span class="paso-numero">1</span>
                <h3>El usuario inicia sesión</h3>
                <p>El servidor comprueba las credenciales y llama a <code>session_start()</code>.</p>
            </li>
            <li class="paso">
                <span class="paso-numero">2</span>
                <h3>Se crea un identificador</h3>
                <p>PHP genera un <code>PHPSESSID</code> y lo envía al navegador en una cookie.</p>
            </li>
            <li class="paso">
                <span class="paso-numero">3</span>
                <h3>Los datos viven en el servidor</h3>
                <p>La información se guarda en <code>$_SESSION</code>; el navegador nunca ve el contenido.</p>
            </li>
            <li class="paso">
                <span class="paso-numero">4</span>
                <h3>Cada petición se reconoce</h3>
                <p>El navegador reenvía la cookie y PHP recupera la sesión correspondiente.</p>
            </li>
        </ol>

        <pre><code>&lt;?php
session_start();

$_SESSION["usuario"] = "admin";
$_SESSION["iniciada"] = time();

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit();
}
?&gt;</code></pre>

        <div class="info-box">
            <strong>Importante:</strong> <code>session_start()</code> debe ejecutarse antes de enviar
            cualquier salida HTML. Si ya se imprimió texto, PHP no puede enviar la cookie.
        </div>
    </section>

    <section class="bloque">
        <h2>Demo: un contador que sobrevive a la recarga</h2>
        <p>
            Este número se guarda en <code>$_SESSION['demo_contador']</code>. Recarga la página o navega
            a otro módulo y volverás a encontrarlo: la sesión sigue activa.
        </p>

        <div class="demo-panel">
            <h3>Contador de sesión</h3>
            <p class="counter"><?= e($contador) ?></p>

            <form action="<?= url('pages/php/sesiones.php') ?>" method="POST" class="calc-acciones">
                <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
                <button type="submit" name="accion" value="sumar">Sumar +1</button>
                <button type="submit" name="accion" value="reiniciar" class="boton boton-secundario">Reiniciar</button>
            </form>

            <p class="small-note">
                El contador de esta demo es independiente de la sesión de acceso que protege el sitio.
            </p>
        </div>
    </section>

    <section class="bloque">
        <h2>Datos de la sesión actual</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>usuario</code></td>
                        <td><?= e($_SESSION['usuario'] ?? '—') ?></td>
                    </tr>
                    <tr>
                        <td><code>nombre</code></td>
                        <td><?= e($_SESSION['nombre'] ?? '—') ?></td>
                    </tr>
                    <tr>
                        <td><code>iniciada</code></td>
                        <td><?= !empty($_SESSION['iniciada']) ? e(date('d/m/Y H:i:s', $_SESSION['iniciada'])) : '—' ?></td>
                    </tr>
                    <tr>
                        <td><code>session_id()</code></td>
                        <td><code><?= e(session_id()) ?></code></td>
                    </tr>
                    <tr>
                        <td><code>demo_contador</code></td>
                        <td><?= e($contador) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="bloque">
        <h2>Seguridad: lo que no se debe olvidar</h2>
        <ul class="lista-caracteristicas">
            <li><strong>Regenerar el identificador</strong> después del login con <code>session_regenerate_id(true)</code>.</li>
            <li><strong>Configurar la cookie</strong> con <code>HttpOnly</code>, <code>SameSite=Lax</code> y <code>Secure</code> cuando haya HTTPS.</li>
            <li><strong>Validar en cada página</strong>: no basta con ocultar el enlace de salida.</li>
            <li><strong>Cerrar la sesión</strong> al salir: limpiar <code>$_SESSION</code>, borrar la cookie y destruirla.</li>
            <li><strong>Usar tokens CSRF</strong> en formularios que modifican datos.</li>
        </ul>

        <pre><code>&lt;?php
// Cierre seguro de sesión
$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $p = session_get_cookie_params();
    setcookie(session_name(), "", time() - 42000,
        $p["path"], $p["domain"], $p["secure"], $p["httponly"]);
}

session_destroy();
?&gt;</code></pre>

        <div class="warning-box">
            <strong>Este sitio ya lo aplica:</strong> todas las páginas llaman a <code>requerirLogin()</code>
            y el login rechaza los campos vacíos. Si cierras sesión, ningún módulo vuelve a abrirse sin credenciales.
        </div>
    </section>

    <section class="bloque">
        <h2>Sesión frente a cookie</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Aspecto</th>
                        <th>Cookie</th>
                        <th>Sesión</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Dónde se guarda</td>
                        <td>En el navegador del usuario.</td>
                        <td>En el servidor.</td>
                    </tr>
                    <tr>
                        <td>Qué viaja</td>
                        <td>El valor completo.</td>
                        <td>Solo el identificador.</td>
                    </tr>
                    <tr>
                        <td>Seguridad</td>
                        <td>Puede manipularse si no se firma.</td>
                        <td>El contenido no sale del servidor.</td>
                    </tr>
                    <tr>
                        <td>Uso típico</td>
                        <td>Preferencias, idioma, recordar usuario.</td>
                        <td>Login, carrito, datos temporales.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
