<?php
/**
 * Pie de página compartido.
 */
?>
<footer class="pie">
    <div class="container pie-contenido">
        <div class="pie-columna">
            <p class="pie-marca"><?= e(APP_NOMBRE) ?></p>
            <p class="pie-texto">Tutor interactivo de desarrollo web, PHP y Python.</p>
        </div>

        <div class="pie-columna">
            <p class="pie-titulo">Contacto</p>
            <a href="mailto:<?= e(APP_CORREO) ?>"><?= e(APP_CORREO) ?></a>
            <a href="<?= e(APP_UNIVERSIDAD) ?>" target="_blank" rel="noopener">Colegio Mayor del Cauca</a>
        </div>

        <div class="pie-columna">
            <p class="pie-titulo">Créditos</p>
            <p class="pie-texto"><?= e(APP_AUTOR) ?></p>
            <p class="pie-texto"><?= date('Y') ?> · Desarrollo de Aplicaciones I</p>
        </div>
    </div>

    <div class="pie-inferior">
        <div class="container">
            <span>Hecho con PHP, Bootstrap y Python</span>
            <a href="<?= url('inicio.php') ?>">Volver al inicio</a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
<script src="<?= url('assets/js/app.js') ?>"></script>
</body>

</html>
