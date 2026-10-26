<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Frontend';
$descripcion = 'Qué es el frontend, sus lenguajes, frameworks y un ejemplo interactivo.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Desarrollo web · 02</span>
        <h1>Frontend: la parte que el usuario toca</h1>
        <p>
            El frontend es todo lo que ocurre en el navegador: estructura, estilos, interacción y
            consumo de datos. Su meta es que la aplicación sea clara, rápida, accesible y agradable.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/web/backend.php') ?>">Siguiente: backend</a>
            <a class="boton boton-secundario" href="<?= url('pages/web/conceptos.php') ?>">Volver a conceptos</a>
        </div>
    </header>

    <section class="bloque">
        <h2>¿Qué es el Frontend?</h2>
        <p>
            Es la parte de la aplicación que el usuario ve e interactúa directamente. Incluye la
            estructura visual, los colores, los botones, las animaciones, los formularios y la
            respuesta a cada clic. Se ejecuta en el navegador, por eso se conoce como
            <strong>lado del cliente</strong>.
        </p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Año</th>
                        <th>Hito</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1991</td><td>Aparece la primera página web con HTML básico.</td></tr>
                    <tr><td>1995</td><td>JavaScript permite reaccionar a clics y validar formularios.</td></tr>
                    <tr><td>1996-1999</td><td>CSS separa el diseño del contenido.</td></tr>
                    <tr><td>2005</td><td>AJAX permite cargar datos sin recargar la página.</td></tr>
                    <tr><td>2010 en adelante</td><td>Crecen React, Vue, Angular y las SPA.</td></tr>
                </tbody>
            </table>
        </div>

        <h3>Características principales</h3>
        <ul class="lista-caracteristicas">
            <li><strong>Interactividad:</strong> responde a las acciones del usuario.</li>
            <li><strong>Responsive:</strong> se adapta a móviles, tablets y escritorios.</li>
            <li><strong>Accesibilidad:</strong> puede ser utilizado por cualquier persona.</li>
            <li><strong>Rendimiento:</strong> carga rápido y consume pocos recursos.</li>
            <li><strong>Compatibilidad:</strong> funciona en distintos navegadores.</li>
        </ul>

        <div class="info-box">
            <strong>Dato clave:</strong> el frontend trabaja con el backend mediante APIs y el
            modelo petición-respuesta.
        </div>
    </section>

    <section class="bloque">
        <h2>Lenguajes y frameworks</h2>
        <p>Todo desarrollador frontend debe dominar estos tres lenguajes base antes de saltar a un framework.</p>

        <div class="technology-grid">
            <article class="technology-card html-card">
                <h3>HTML5</h3>
                <p>Define la estructura: títulos, párrafos, imágenes, enlaces y formularios.</p>
                <span>Año 2014 · estructura</span>
            </article>
            <article class="technology-card css-card">
                <h3>CSS</h3>
                <p>Controla colores, tipografías, márgenes, animaciones y diseño responsive.</p>
                <span>Año 1994 · apariencia</span>
            </article>
            <article class="technology-card js-card">
                <h3>JavaScript</h3>
                <p>Añade eventos, peticiones a APIs, animaciones y validaciones.</p>
                <span>Año 1995 · comportamiento</span>
            </article>
            <article class="technology-card">
                <h3>React</h3>
                <p>Librería de Meta para crear interfaces mediante componentes reutilizables.</p>
                <span>Componentes · SPA</span>
            </article>
            <article class="technology-card">
                <h3>Vue.js</h3>
                <p>Framework progresivo, flexible y fácil de aprender para construir interfaces.</p>
                <span>Progresivo · flexible</span>
            </article>
            <article class="technology-card">
                <h3>Angular</h3>
                <p>Framework de Google con estructura completa para aplicaciones empresariales.</p>
                <span>Robusto · empresarial</span>
            </article>
        </div>

        <div class="success-box">
            <strong>Regla de oro:</strong> aprende bien HTML, CSS y JavaScript puro antes de saltar a un framework.
        </div>
    </section>

    <section class="bloque">
        <h2>Código de ejemplo</h2>
        <p>Este ejemplo combina HTML, CSS y JavaScript en una sola página:</p>

        <pre><code>&lt;h1&gt;Mi primer Frontend&lt;/h1&gt;
&lt;p id="contador"&gt;0&lt;/p&gt;
&lt;button onclick="sumar()"&gt;Sumar +1&lt;/button&gt;

&lt;script&gt;
    let cuenta = 0;

    function sumar() {
        cuenta++;
        document.getElementById('contador').textContent = cuenta;
    }
&lt;/script&gt;</code></pre>

        <div class="demo-panel">
            <h3>Demo funcional</h3>
            <p>Presiona el botón para modificar el contenido de la página con JavaScript.</p>
            <p id="demoContador" class="counter">0</p>
            <div class="calc-acciones">
                <button id="sumarDemo" type="button">Sumar +1</button>
                <button id="reiniciarDemo" type="button" class="boton boton-secundario">Reiniciar</button>
            </div>
        </div>

        <h3>¿Qué hace este código?</h3>
        <ul class="lista-caracteristicas">
            <li><strong>HTML:</strong> crea el título, el contador y los botones.</li>
            <li><strong>CSS:</strong> define color, tamaño, espaciado y alineación.</li>
            <li><strong>JavaScript:</strong> escucha el clic y actualiza el contador.</li>
        </ul>
    </section>

    <section class="bloque">
        <h2>Buenas prácticas de frontend</h2>
        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">♿</span>
                <h3>Accesibilidad</h3>
                <p>Etiquetas semánticas, contraste suficiente, foco visible y textos alternativos.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">📱</span>
                <h3>Mobile first</h3>
                <p>Diseña primero para pantallas pequeñas y luego amplía con media queries.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">⚡</span>
                <h3>Rendimiento</h3>
                <p>Optimiza imágenes, evita scripts innecesarios y mide con DevTools.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🧪</span>
                <h3>Pruebas</h3>
                <p>Verifica en varios navegadores y valida el HTML con las herramientas del W3C.</p>
            </article>
        </div>
    </section>
</main>

<script>
    let cuentaFrontend = 0;
    const contadorFrontend = document.getElementById('demoContador');

    document.getElementById('sumarDemo').addEventListener('click', () => {
        cuentaFrontend++;
        contadorFrontend.textContent = cuentaFrontend;
    });

    document.getElementById('reiniciarDemo').addEventListener('click', () => {
        cuentaFrontend = 0;
        contadorFrontend.textContent = cuentaFrontend;
    });
</script>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
