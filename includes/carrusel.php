<?php
/**
 * Carrusel de banners del curso (va arriba de la barra de navegación).
 * Banners de Ivan Beltran: assets/img/carousel1.svg, carousel2.svg y carousel3.svg (proporción 4:1).
 */
$banners = [
    ['archivo' => 'assets/img/carousel1.svg', 'alt' => 'Tecnologías utilizadas'],
    ['archivo' => 'assets/img/carousel2.svg', 'alt' => 'Contacto y repositorios'],
    ['archivo' => 'assets/img/carousel3.svg', 'alt' => 'Sistemas operativos'],
];
?>
<header class="cabecera">
    <div id="carruselBanners" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <?php foreach ($banners as $indice => $banner): ?>
                <button type="button" data-bs-target="#carruselBanners" data-bs-slide-to="<?= $indice ?>"
                    <?= $indice === 0 ? 'class="active" aria-current="true"' : '' ?>
                    aria-label="Banner <?= $indice + 1 ?>"></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner">
            <?php foreach ($banners as $indice => $banner): ?>
                <div class="carousel-item<?= $indice === 0 ? ' active' : '' ?>">
                    <img src="<?= url($banner['archivo']) ?>" class="d-block w-100" alt="<?= e($banner['alt']) ?>"
                        <?= $indice === 0 ? '' : 'loading="lazy"' ?>>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carruselBanners" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carruselBanners" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</header>
