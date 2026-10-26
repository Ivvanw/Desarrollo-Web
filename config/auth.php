<?php
/**
 * Autenticación del tutor.
 *
 * Todas las páginas del sitio (excepto index.php y logout.php) deben incluir
 * este archivo y llamar a requerirLogin(). De esta forma, si no hay una
 * sesión iniciada, el visitante no puede abrir ninguna página del tutor.
 */

require_once __DIR__ . '/config.php';

// Credenciales de demostración. Cambiar por una base de datos en producción.
const USUARIO_DEMO = 'admin';
const CLAVE_HASH = 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3'; // 123

/**
 * Comprueba que el usuario y la clave correspondan a la cuenta demo.
 */
function credencialesValidas(string $usuario, string $clave): bool
{
    return hash_equals(USUARIO_DEMO, $usuario)
        && hash_equals(CLAVE_HASH, hash('sha256', $clave));
}

function estaAutenticado(): bool
{
    return !empty($_SESSION['usuario']);
}

/**
 * Redirige al login si el visitante no ha iniciado sesión.
 */
function requerirLogin(): void
{
    if (estaAutenticado()) {
        return;
    }

    $_SESSION['flash_error'] = 'Debes iniciar sesión para acceder a las páginas del tutor.';
    header('Location: ' . url('index.php'));
    exit();
}

/**
 * Crea la sesión del usuario autenticado.
 */
function iniciarSesionUsuario(string $usuario): void
{
    session_regenerate_id(true);
    $_SESSION['usuario'] = $usuario;
    $_SESSION['nombre'] = 'Ivan Andres Chimunja';
    $_SESSION['iniciada'] = time();
    unset($_SESSION['flash_error']);
}

/**
 * Destruye la sesión actual.
 */
function cerrarSesion(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $parametros = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $parametros['path'],
            $parametros['domain'],
            $parametros['secure'],
            $parametros['httponly']
        );
    }

    session_destroy();
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf'];
}

function csrfValido(?string $token): bool
{
    return is_string($token)
        && !empty($_SESSION['csrf'])
        && hash_equals($_SESSION['csrf'], $token);
}
