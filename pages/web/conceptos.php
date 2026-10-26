<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Evolución de los sistemas';
$descripcion = 'Mainframe, terminales, cliente-servidor, dos y tres niveles, multinivel.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

$sistemas = [
    [
        'id' => 'mainframe',
        'titulo' => '1. Mainframe',
        'imagenes' => ['mainframe-1.svg', 'mainframe-2.svg', 'mainframe-3.svg'],
        'pregunta' => '¿Qué es un Mainframe?',
        'descripcion' => 'Un <strong>mainframe</strong> es un computador de gran capacidad diseñado para procesar enormes cantidades de datos y ejecutar muchas operaciones de forma simultánea, segura y confiable. Se usa en bancos, gobiernos, aseguradoras y aerolíneas.',
        'listaTitulo' => 'Características principales',
        'items' => [
            'Alta capacidad de procesamiento.',
            'Procesamiento de grandes volúmenes de datos.',
            'Alta seguridad y confiabilidad.',
            'Funcionamiento continuo las 24 horas.',
            'Soporte para miles de usuarios simultáneos.',
        ],
        'dato' => '<strong>Origen:</strong> se desarrolló y popularizó durante la década de <strong>1960</strong>.',
    ],
    [
        'id' => 'terminal',
        'titulo' => '2. Terminal bruta',
        'imagenes' => ['terminal-1.svg', 'terminal-2.svg', 'terminal-3.svg'],
        'pregunta' => '¿Qué es una Terminal Bruta?',
        'descripcion' => 'Una <strong>terminal bruta</strong> es un dispositivo sin capacidad significativa de procesamiento ni almacenamiento. Permite ingresar datos y visualizar la información procesada por un computador central.',
        'listaTitulo' => 'Características principales',
        'items' => [
            'No realiza procesamiento complejo de manera independiente.',
            'No requiere almacenamiento local significativo.',
            'Depende de un computador central.',
            'Permite ingresar comandos y datos.',
            'Muestra los resultados enviados por el sistema central.',
        ],
        'dato' => '<strong>Periodo:</strong> se popularizó durante las décadas de <strong>1960 y 1970</strong>.',
    ],
    [
        'id' => 'cliente-servidor',
        'titulo' => '3. Cliente-Servidor',
        'imagenes' => ['cliente-servidor-1.svg', 'cliente-servidor-2.svg', 'cliente-servidor-3.svg'],
        'pregunta' => '¿Qué es el modelo Cliente-Servidor?',
        'descripcion' => 'Es una arquitectura en la que los <strong>clientes</strong> solicitan recursos o servicios y los <strong>servidores</strong> los proporcionan y procesan. El cliente pide, el servidor responde.',
        'listaTitulo' => 'Modelo petición-respuesta',
        'items' => [
            'El cliente envía una petición al servidor.',
            'El servidor recibe y procesa la petición.',
            'El servidor devuelve una respuesta.',
            'El cliente presenta el resultado al usuario.',
        ],
        'dato' => '<strong>Consolidación:</strong> se extendió en los <strong>años 80</strong> con las redes locales.',
    ],
    [
        'id' => 'dos-niveles',
        'titulo' => '4. Cliente-Servidor de 2 niveles',
        'imagenes' => ['dos-niveles-1.svg', 'dos-niveles-2.svg', 'dos-niveles-3.svg'],
        'pregunta' => 'Arquitectura de 2 niveles',
        'descripcion' => 'Es la forma básica del modelo cliente-servidor. Tiene dos capas que se comunican directamente: el cliente y el servidor.',
        'listaTitulo' => 'Capas',
        'items' => [
            '<strong>Cliente:</strong> contiene la interfaz y envía peticiones.',
            '<strong>Servidor:</strong> almacena la base de datos y ejecuta la lógica.',
            'Comunicación directa entre cliente y servidor.',
            'Implementación sencilla para sistemas pequeños.',
            'Escalabilidad limitada con muchos usuarios.',
        ],
        'dato' => '<strong>Periodo:</strong> se popularizó en los <strong>años 80 y 90</strong> con aplicaciones conectadas directamente a bases de datos.',
    ],
    [
        'id' => 'tres-niveles',
        'titulo' => '5. Cliente-Servidor de 3 niveles',
        'imagenes' => ['tres-niveles-1.svg', 'tres-niveles-2.svg', 'tres-niveles-3.svg'],
        'pregunta' => 'Arquitectura de 3 niveles',
        'descripcion' => 'Divide la aplicación en tres capas independientes: presentación, lógica de negocio y datos. Esto facilita la escalabilidad, la seguridad y el mantenimiento.',
        'listaTitulo' => 'Las tres capas',
        'items' => [
            '<strong>Presentación:</strong> interfaz con la que interactúa el usuario.',
            '<strong>Lógica de negocio:</strong> valida datos y ejecuta las reglas.',
            '<strong>Datos:</strong> almacena y gestiona la información.',
            'El cliente no accede directamente a la base de datos.',
            'Mantenimiento independiente de cada capa.',
        ],
        'dato' => '<strong>Popularización:</strong> se extendió a finales de los <strong>años 90</strong> con el auge de las aplicaciones web.',
    ],
    [
        'id' => 'multinivel',
        'titulo' => '6. Cliente-Servidor Multinivel',
        'imagenes' => ['multinivel-1.svg', 'multinivel-2.svg', 'multinivel-3.svg'],
        'pregunta' => 'Arquitectura multinivel',
        'descripcion' => 'La arquitectura <strong>multinivel</strong> divide una aplicación en múltiples capas independientes, cada una especializada en una función.',
        'listaTitulo' => 'Capas típicas',
        'items' => [
            'Presentación: interfaz web, móvil o de escritorio.',
            'Servicios web o API: entrada al sistema.',
            'Lógica de negocio: reglas y procesos.',
            'Acceso a datos: comunicación con la base de datos.',
            'Persistencia e infraestructura: almacenamiento, servidores y colas.',
        ],
        'dato' => '<strong>Expansión:</strong> su auge comenzó en los <strong>años 2000</strong> con Internet, la nube y los microservicios.',
    ],
];
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Desarrollo web · 01</span>
        <h1>Evolución de los sistemas computacionales</h1>
        <p>
            Antes de escribir una línea de código conviene entender cómo llegamos hasta aquí.
            Cada arquitectura resolvió un problema de su época y dejó una idea que todavía usamos.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/web/frontend.php') ?>">Siguiente: frontend</a>
            <a class="boton boton-secundario" href="<?= url('pages/web/presentacion.php') ?>">Conocer al autor</a>
        </div>
    </header>

    <section class="bloque">
        <div class="fila-encabezado">
            <div>
                <span class="section-kicker">Línea de tiempo</span>
                <h2 class="mb-0">Seis etapas clave</h2>
            </div>
            <span class="badge-pill">1960 → hoy</span>
        </div>

        <div class="accordion" id="sistemasAccordion">
            <?php foreach ($sistemas as $indice => $sistema): ?>
                <section class="accordion-item">
                    <h2 class="accordion-header" id="heading-<?= e($sistema['id']) ?>">
                        <button class="accordion-button<?= $indice === 0 ? '' : ' collapsed' ?>" type="button"
                            data-bs-toggle="collapse" data-bs-target="#panel-<?= e($sistema['id']) ?>"
                            aria-expanded="<?= $indice === 0 ? 'true' : 'false' ?>"
                            aria-controls="panel-<?= e($sistema['id']) ?>">
                            <?= e($sistema['titulo']) ?>
                        </button>
                    </h2>
                    <div id="panel-<?= e($sistema['id']) ?>" class="accordion-collapse collapse<?= $indice === 0 ? ' show' : '' ?>"
                        aria-labelledby="heading-<?= e($sistema['id']) ?>" data-bs-parent="#sistemasAccordion">
                        <div class="accordion-body concept-layout">
                            <div id="carousel-<?= e($sistema['id']) ?>" class="carousel slide concept-carousel"
                                data-bs-ride="carousel" data-bs-interval="4500">
                                <div class="carousel-inner">
                                    <?php foreach ($sistema['imagenes'] as $i => $imagen): ?>
                                        <div class="carousel-item<?= $i === 0 ? ' active' : '' ?>">
                                            <img src="<?= url('assets/img/' . $imagen) ?>"
                                                alt="<?= e($sistema['titulo']) ?> · ilustración <?= e($i + 1) ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carousel-<?= e($sistema['id']) ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Anterior</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carousel-<?= e($sistema['id']) ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Siguiente</span>
                                </button>
                            </div>

                            <article class="concepto">
                                <h2><?= e($sistema['pregunta']) ?></h2>
                                <p><?= $sistema['descripcion'] ?></p>
                                <h3><?= e($sistema['listaTitulo']) ?></h3>
                                <ul>
                                    <?php foreach ($sistema['items'] as $item): ?>
                                        <li><?= $item ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="dato"><?= $sistema['dato'] ?></div>
                            </article>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="bloque">
        <h2>La idea que se repite</h2>
        <p>
            Todas las etapas separan responsabilidades: quién muestra, quién decide y quién guarda.
            Esa separación es la base de las arquitecturas actuales y de conceptos como frontend,
            backend y API que verás en los siguientes módulos.
        </p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Etapa</th>
                        <th>Época</th>
                        <th>Aporte principal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Mainframe</td><td>1960</td><td>Procesamiento centralizado de alto volumen.</td></tr>
                    <tr><td>Terminal bruta</td><td>1960-1970</td><td>Acceso remoto sin capacidad de cómputo local.</td></tr>
                    <tr><td>Cliente-servidor</td><td>1980</td><td>Reparto de tareas entre cliente y servidor.</td></tr>
                    <tr><td>Dos niveles</td><td>1980-1990</td><td>Cliente con interfaz y servidor con datos.</td></tr>
                    <tr><td>Tres niveles</td><td>1990</td><td>Separación de presentación, lógica y datos.</td></tr>
                    <tr><td>Multinivel</td><td>2000 en adelante</td><td>Servicios, nube y microservicios.</td></tr>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
