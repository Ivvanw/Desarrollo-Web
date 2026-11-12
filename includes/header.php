<?php
/**
 * Barra superior (estilo GitHub) del tutor de PHP + encabezado del "repositorio".
 * El tutor de PHP es libre; el enlace a Python indica si el área privada está abierta.
 */
$nombreUsuario = $_SESSION['nombre'] ?? 'Invitado';
require_once __DIR__ . '/../config/auth.php';
require __DIR__ . '/carrusel.php';
?>
<nav class="navbar navbar-expand-xl barra-nav sticky-top" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand marca" href="<?= url('index.php') ?>">
            <span class="marca-icono"><?= icono('tutor', 18) ?></span>
            <span>Tutor de PHP</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
            aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav ms-auto align-items-xl-center">
                <li class="nav-item">
                    <a class="nav-link<?= activo('index.php') ?>" href="<?= url('index.php') ?>">Inicio</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?= activoCarpeta('pages/web') ?>" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Web</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= url('pages/web/conceptos.php') ?>">Evolución de sistemas</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/web/frontend.php') ?>">Frontend</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/web/backend.php') ?>">Backend</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/web/api.php') ?>">APIs</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/web/css.php') ?>">CSS</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/web/presentacion.php') ?>">Presentación</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?= activoCarpeta('pages/php') ?>" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">PHP</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= url('pages/php/index.php') ?>">¿Qué es PHP?</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/php/variables.php') ?>">Variables</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/php/condicionales.php') ?>">Condicionales</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/php/ciclos.php') ?>">Ciclos</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/php/vectores.php') ?>">Vectores</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/php/sesiones.php') ?>">Sesiones</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/php/base-datos.php') ?>">Base de datos</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link<?= activo('pages/ia.php') ?>" href="<?= url('pages/ia.php') ?>">IA</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link<?= activo('pages/material/index.php') ?>" href="<?= url('pages/material/index.php') ?>">Material</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= url('manual-python/index.php') ?>">
                        Python <span class="nav-candado"><?= estaAutenticado() ? 'abierto' : '🔒 privado' ?></span>
                    </a>
                </li>

                <?php if (estaAutenticado()): ?>
                    <li class="nav-item usuario-chip d-none d-xxl-flex">
                        <span class="usuario-icono" aria-hidden="true"><?= e(mb_substr($nombreUsuario, 0, 1)) ?></span>
                        <span class="usuario-texto">
                            <strong><?= e($nombreUsuario) ?></strong>
                            <small>Sesión activa</small>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-salir" href="<?= url('logout.php') ?>">Salir</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="zona-banner">
    <div class="container">
        <div class="zona-titulo">
            <span class="zona-icono" aria-hidden="true"><?= icono('tutor', 24) ?></span>
            <div>
                <p class="zona-nombre">Tutor de PHP</p>
                <p class="zona-texto">Desarrollo de Aplicaciones I · HTML, CSS y PHP</p>
            </div>
        </div>
        <div class="repo-temas" aria-label="Temas">
            <span class="tema">html</span>
            <span class="tema">css</span>
            <span class="tema">javascript</span>
            <span class="tema">php</span>
            <span class="tema">mysql</span>
        </div>
    </div>
</div>
