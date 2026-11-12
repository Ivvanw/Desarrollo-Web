<?php
/**
 * Barra superior (estilo GitHub) del manual de Python.
 * Solo se incluye en páginas protegidas de manual-python/.
 */
$nombreUsuario = $_SESSION['nombre'] ?? 'Invitado';
require __DIR__ . '/carrusel.php';
?>
<nav class="navbar navbar-expand-xl barra-nav sticky-top" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand marca" href="<?= url('manual-python/index.php') ?>">
            <span class="marca-icono"><?= icono('python', 18) ?></span>
            <span>Manual de Python</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
            aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav ms-auto align-items-xl-center">
                <li class="nav-item">
                    <a class="nav-link<?= activo('manual-python/index.php') ?>" href="<?= url('manual-python/index.php') ?>">Conceptos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= activo('manual-python/variables.php') ?>" href="<?= url('manual-python/variables.php') ?>">Variables</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= activo('manual-python/operadores.php') ?>" href="<?= url('manual-python/operadores.php') ?>">Operadores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= activo('manual-python/comandos.php') ?>" href="<?= url('manual-python/comandos.php') ?>">Comandos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= activo('manual-python/graficas.php') ?>" href="<?= url('manual-python/graficas.php') ?>">Gráficas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= activo('manual-python/matplotlib.php') ?>" href="<?= url('manual-python/matplotlib.php') ?>">Matplotlib</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= activo('manual-python/analisis-datos.php') ?>" href="<?= url('manual-python/analisis-datos.php') ?>">Análisis</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= url('index.php') ?>">← PHP</a>
                </li>

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
            </ul>
        </div>
    </div>
</nav>

<div class="zona-banner">
    <div class="container">
        <div class="zona-titulo">
            <span class="zona-icono" aria-hidden="true"><?= icono('python', 24) ?></span>
            <div>
                <p class="zona-nombre">Manual de Python</p>
                <p class="zona-texto">Desarrollo de Aplicaciones I · datos y gráficas</p>
            </div>
        </div>
        <div class="repo-temas" aria-label="Temas">
            <span class="tema">python</span>
            <span class="tema">pandas</span>
            <span class="tema">matplotlib</span>
            <span class="tema">csv</span>
            <span class="tema">pdf</span>
        </div>
    </div>
</div>
