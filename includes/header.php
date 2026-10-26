<?php
/**
 * Cabecera visual + menú principal.
 * Solo se incluye en páginas protegidas.
 */
$nombreUsuario = $_SESSION['nombre'] ?? 'Invitado';
?>
<header class="cabecera">
    <div id="cabeceraCarrusel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5500">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?= url('assets/img/carousel1.svg') ?>" class="d-block w-100" alt="Ilustración de desarrollo web">
            </div>
            <div class="carousel-item">
                <img src="<?= url('assets/img/carousel2.svg') ?>" class="d-block w-100" alt="Ilustración de programación">
            </div>
            <div class="carousel-item">
                <img src="<?= url('assets/img/carousel3.svg') ?>" class="d-block w-100" alt="Ilustración de datos y gráficas">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#cabeceraCarrusel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#cabeceraCarrusel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    <div class="cabecera-franja container">
        <span class="cabecera-etiqueta">Tutor de desarrollo web</span>
        <span class="cabecera-separador" aria-hidden="true"></span>
        <span class="cabecera-detalle">HTML · CSS · JavaScript · PHP · Python</span>
    </div>
</header>

<nav class="navbar navbar-expand-xl barra-nav sticky-top" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand marca" href="<?= url('inicio.php') ?>">
            <span class="marca-icono">&lt;/&gt;</span>
            <span>Tutor Web</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
            aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav ms-auto align-items-xl-center">
                <li class="nav-item">
                    <a class="nav-link<?= activo('inicio.php') ?>" href="<?= url('inicio.php') ?>">Inicio</a>
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

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?= activoCarpeta('pages/python') ?>" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Python</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= url('pages/python/index.php') ?>">Conceptos</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/python/variables.php') ?>">Variables</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/python/operadores.php') ?>">Operadores</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/python/comandos.php') ?>">Comandos</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/python/graficas.php') ?>">Gráficas</a></li>
                        <li><a class="dropdown-item" href="<?= url('pages/python/matplotlib.php') ?>">CSV y Matplotlib</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= url('pages/python/analisis-datos.php') ?>">Análisis climático</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link<?= activo('pages/ia.php') ?>" href="<?= url('pages/ia.php') ?>">IA</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link<?= activo('pages/material/index.php') ?>" href="<?= url('pages/material/index.php') ?>">Material</a>
                </li>

                <li class="nav-item usuario-chip d-none d-xl-flex">
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
