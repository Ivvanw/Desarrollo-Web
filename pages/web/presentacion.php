<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Presentación';
$descripcion = 'Presentación personal, formación académica y experiencia laboral del autor.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Desarrollo web · 06</span>
        <h1>Presentación personal</h1>
        <p>
            Esta página reúne los datos personales, la formación académica y la experiencia laboral
            del autor del tutor. Es un ejemplo de maquetación con HTML semántico y CSS.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/material/index.php') ?>">Ir al material</a>
            <a class="boton boton-secundario" href="<?= url('pages/web/css.php') ?>">Volver a CSS</a>
        </div>
    </header>

    <div class="accordion" id="datosAccordion">
        <section class="accordion-item">
            <h2 class="accordion-header" id="personalTitle">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#personalData" aria-expanded="true" aria-controls="personalData">
                    1. Datos personales
                </button>
            </h2>
            <div id="personalData" class="accordion-collapse collapse show" aria-labelledby="personalTitle"
                data-bs-parent="#datosAccordion">
                <div class="accordion-body personal-layout">
                    <div class="profile-box">
                        <img src="<?= url('assets/img/foto-perfil.jpg') ?>" alt="Foto de perfil">
                        <h2><?= e(APP_AUTOR) ?></h2>
                        <p>Tecnólogo en Desarrollo de Software</p>
                    </div>

                    <section class="data-panel">
                        <h2>Información personal</h2>
                        <div class="data-table">
                            <div><strong>Nombre completo</strong><span><?= e(APP_AUTOR) ?></span></div>
                            <div><strong>Cédula de ciudadanía</strong><span>1058669537</span></div>
                            <div><strong>Edad</strong><span>19 años</span></div>
                            <div><strong>Fecha de nacimiento</strong><span>30 de mayo de 2007</span></div>
                            <div><strong>Lugar de residencia</strong><span>La Venta, Cajibío</span></div>
                            <div><strong>Dirección</strong><span>La Venta</span></div>
                            <div><strong>Teléfono</strong><span>3128127575</span></div>
                            <div><strong>Correo electrónico</strong><span><?= e(APP_CORREO) ?></span></div>
                            <div><strong>Estado civil</strong><span>Soltero</span></div>
                            <div><strong>Religión</strong><span>N/A</span></div>
                            <div><strong>Orientación sexual</strong><span>Heterosexual</span></div>
                            <div><strong>Raza</strong><span>Mestiza</span></div>
                            <div><strong>Alergias</strong><span>Ninguna conocida</span></div>
                            <div><strong>Antecedentes penales</strong><span>Ninguno</span></div>
                        </div>
                    </section>
                </div>
            </div>
        </section>

        <section class="accordion-item">
            <h2 class="accordion-header" id="educationTitle">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#education" aria-expanded="false" aria-controls="education">
                    2. Formación académica
                </button>
            </h2>
            <div id="education" class="accordion-collapse collapse" aria-labelledby="educationTitle"
                data-bs-parent="#datosAccordion">
                <div class="accordion-body">
                    <h2>Estudios realizados</h2>
                    <p>A continuación se relacionan los estudios completados y los que se encuentran actualmente en curso:</p>
                    <div class="data-table education-table">
                        <div><strong>Primaria</strong><span>Estudios completados satisfactoriamente.</span></div>
                        <div><strong>Bachillerato</strong><span>Estudios completados satisfactoriamente.</span></div>
                        <div><strong>Estudios actuales</strong><span>Tecnólogo en Desarrollo de Software · Colegio Mayor del Cauca</span></div>
                        <div><strong>Semestre actual</strong><span>Quinto semestre</span></div>
                        <div><strong>Estado</strong><span class="status success">En curso</span></div>
                    </div>
                    <div class="info-box">
                        <strong>Nota:</strong> actualmente se encuentra cursando quinto semestre del tecnólogo en
                        Desarrollo de Software en el Colegio Mayor del Cauca.
                    </div>
                </div>
            </div>
        </section>

        <section class="accordion-item">
            <h2 class="accordion-header" id="workTitle">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#work" aria-expanded="false" aria-controls="work">
                    3. Experiencia laboral
                </button>
            </h2>
            <div id="work" class="accordion-collapse collapse" aria-labelledby="workTitle"
                data-bs-parent="#datosAccordion">
                <div class="accordion-body">
                    <h2>Experiencia laboral</h2>
                    <p>A continuación se relaciona la experiencia laboral adquirida hasta la fecha:</p>
                    <div class="data-table">
                        <div><strong>Cargo</strong><span>Mantenimiento y ensamble de equipos de cómputo y redes</span></div>
                        <div><strong>Tiempo de servicio</strong><span>Un año</span></div>
                        <div><strong>Funciones principales</strong><span>Mantenimiento y ensamble de equipos de cómputo y redes.</span></div>
                        <div><strong>Pasantías</strong><span class="status neutral">No registra</span></div>
                    </div>
                    <div class="info-box warning-box">
                        <strong>Observación:</strong> a la fecha no ha realizado pasantías.
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="bloque">
        <h2>Contacto</h2>
        <p>Puedes comunicarte con el autor del tutor a través de los siguientes medios:</p>
        <div class="page-actions">
            <a class="boton" href="mailto:<?= e(APP_CORREO) ?>">Correo institucional</a>
            <a class="boton boton-secundario" href="<?= e(APP_UNIVERSIDAD) ?>" target="_blank" rel="noopener">Mi universidad</a>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
