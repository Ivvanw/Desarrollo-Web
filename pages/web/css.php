<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'CSS';
$descripcion = 'Hojas de estilo en cascada: definición, formas de uso y demostración interactiva.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Desarrollo web · 05</span>
        <h1>CSS: Hojas de Estilo en Cascada</h1>
        <p>
            <strong>CSS</strong> (<em>Cascading Style Sheets</em>) define la apariencia de un documento HTML:
            colores, tipografías, tamaños, márgenes, posiciones, animaciones y diseño responsive. Separa el
            contenido de la presentación y permite reutilizar estilos en todo un sitio.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/web/presentacion.php') ?>">Siguiente: presentación</a>
            <a class="boton boton-secundario" href="<?= url('pages/web/api.php') ?>">Volver a APIs</a>
        </div>
    </header>

    <section class="bloque">
        <h2>Historia y características</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Año</th>
                        <th>Hito</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1994</td><td>Håkon Wium Lie propone las hojas de estilo en cascada.</td></tr>
                    <tr><td>1996</td><td>El W3C publica CSS1.</td></tr>
                    <tr><td>1998</td><td>Aparece CSS2 con posicionamiento y medios.</td></tr>
                    <tr><td>2011</td><td>CSS3 se divide en módulos: flexbox, grid y animaciones.</td></tr>
                    <tr><td>2023 en adelante</td><td>Se consolidan container queries, nesting y variables.</td></tr>
                </tbody>
            </table>
        </div>

        <h3>Conceptos fundamentales</h3>
        <ul class="lista-caracteristicas">
            <li><strong>Cascada:</strong> los estilos se aplican según un orden de prioridad.</li>
            <li><strong>Herencia:</strong> algunas propiedades pasan de padres a hijos.</li>
            <li><strong>Especificidad:</strong> las reglas más específicas tienen prioridad.</li>
            <li><strong>Reutilización:</strong> una clase puede usarse en muchos elementos.</li>
            <li><strong>Responsive:</strong> adapta el diseño a cualquier pantalla.</li>
            <li><strong>Modularidad:</strong> CSS3 se organiza en módulos independientes.</li>
        </ul>

        <div class="info-box">
            <strong>Dato clave:</strong> el nombre «cascada» indica que el navegador decide qué regla aplicar
            siguiendo un orden jerárquico: origen, especificidad y orden de aparición.
        </div>
    </section>

    <section class="bloque">
        <h2>Formas de escribir y distribuir CSS</h2>
        <div class="technology-grid">
            <article class="technology-card">
                <h3>CSS en línea</h3>
                <p>Se escribe directamente en la etiqueta HTML con el atributo <code>style</code>.</p>
                <code>&lt;p style="color: red;"&gt;</code>
            </article>
            <article class="technology-card">
                <h3>CSS interno</h3>
                <p>Se coloca dentro de una etiqueta <code>&lt;style&gt;</code> en el <code>&lt;head&gt;</code>.</p>
                <code>&lt;style&gt; p { color: red; } &lt;/style&gt;</code>
            </article>
            <article class="technology-card">
                <h3>CSS externo</h3>
                <p>Se guarda en un archivo <code>.css</code> y se enlaza con <code>&lt;link&gt;</code>. Es la opción recomendada.</p>
                <code>&lt;link rel="stylesheet"&gt;</code>
            </article>
            <article class="technology-card">
                <h3>Preprocesadores</h3>
                <p>Extienden CSS con variables, funciones y anidación.</p>
                <span>Sass · Less · Stylus</span>
            </article>
            <article class="technology-card">
                <h3>Frameworks CSS</h3>
                <p>Incluyen estilos predefinidos para acelerar el desarrollo.</p>
                <span>Bootstrap · Tailwind · Bulma</span>
            </article>
            <article class="technology-card">
                <h3>Metodologías</h3>
                <p>Convenciones para escribir CSS ordenado y escalable.</p>
                <span>BEM · OOCSS · SMACSS</span>
            </article>
        </div>

        <div class="success-box">
            <strong>Regla de oro:</strong> aprende CSS puro antes de saltar a un framework o preprocesador.
        </div>
    </section>

    <section class="bloque">
        <h2>Demostración de código</h2>
        <p>Este código transforma un HTML simple con colores, espaciado, sombras y transiciones:</p>

        <pre><code>&lt;style&gt;
    .tarjeta {
        padding: 30px;
        background: #141b26;
        color: #f0a43a;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        text-align: center;
    }

    .boton:hover {
        background: #4c8dff;
    }
&lt;/style&gt;</code></pre>

        <div class="css-demo">
            <div class="demo-card">
                <h3>Hola CSS</h3>
                <p>Este diseño fue creado con colores, sombras, bordes y transiciones.</p>
                <button id="cssDemoButton" type="button">Haz clic aquí</button>
                <p id="cssMessage" class="demo-message" aria-live="polite"></p>
            </div>
        </div>

        <h3>¿Qué hace este código?</h3>
        <ul class="lista-caracteristicas">
            <li><strong>.tarjeta:</strong> crea una tarjeta con fondo, bordes y sombra.</li>
            <li><strong>.boton:</strong> aplica estilos al botón.</li>
            <li><strong>:hover:</strong> cambia el estilo cuando el cursor pasa encima.</li>
            <li><strong>transition:</strong> suaviza los cambios visuales.</li>
            <li><strong>box-shadow:</strong> agrega profundidad al elemento.</li>
        </ul>

        <div class="info-box">
            <strong>Tip:</strong> abre las DevTools con <kbd>F12</kbd> para modificar estilos CSS en vivo.
        </div>
    </section>

    <section class="bloque">
        <h2>Del CSS a la página completa</h2>
        <p>
            El diseño de este mismo sitio está construido con variables CSS, grid, flexbox y media queries.
            Observa cómo cambian las tarjetas y el menú al reducir el ancho de la ventana.
        </p>

        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🎨</span>
                <h3>Variables</h3>
                <p><code>--azul</code>, <code>--fondo</code> y <code>--radio</code> centralizan el tema oscuro.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">📐</span>
                <h3>Grid y flexbox</h3>
                <p>Organizan el contenido en columnas que se reacomodan en pantallas pequeñas.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">📱</span>
                <h3>Media queries</h3>
                <p>Cambian tamaños y disposición según el ancho disponible.</p>
            </article>
        </div>
    </section>
</main>

<script>
    const cssMessage = document.getElementById('cssMessage');

    document.getElementById('cssDemoButton').addEventListener('click', () => {
        cssMessage.textContent = '¡Funciona! CSS y JavaScript juntos.';

        setTimeout(() => {
            cssMessage.textContent = '';
        }, 2000);
    });
</script>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
