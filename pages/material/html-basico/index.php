<?php
require_once __DIR__ . '/../../../config/auth.php';
requerirLogin();

$titulo = 'HTML básico';
$descripcion = 'Ejercicios y ejemplos de HTML: estructura, texto, tablas, imágenes, enlaces, listas, carrusel y CSS.';
require __DIR__ . '/../../../includes/head.php';
require __DIR__ . '/../../../includes/header.php';
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Material · HTML básico</span>
        <h1>HTML: del primer documento a la página completa</h1>
        <p>
            Estos ejemplos provienen de los ejercicios originales del curso. Cada sección muestra el
            concepto, una demostración funcional y el código que lo produce. Todos los ejemplos se
            ejecutan dentro de este mismo sitio protegido.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/material/index.php') ?>">Volver al material</a>
            <a class="boton boton-secundario" href="<?= url('pages/web/frontend.php') ?>">Repasar frontend</a>
        </div>
    </header>

    <nav class="bloque" aria-label="Contenido de HTML básico">
        <h2>Contenido</h2>
        <div class="page-actions">
            <a class="boton boton-secundario" href="#estructura">Estructura</a>
            <a class="boton boton-secundario" href="#texto">Texto</a>
            <a class="boton boton-secundario" href="#tablas">Tablas</a>
            <a class="boton boton-secundario" href="#imagenes">Imágenes</a>
            <a class="boton boton-secundario" href="#enlaces">Enlaces</a>
            <a class="boton boton-secundario" href="#listas">Listas</a>
            <a class="boton boton-secundario" href="#carrusel">Carrusel</a>
            <a class="boton boton-secundario" href="#css">CSS</a>
            <a class="boton boton-secundario" href="#teoria">Teoría web</a>
        </div>
    </nav>

    <section class="bloque" id="estructura">
        <span class="section-kicker">Lección 01</span>
        <h2>Estructura de un documento HTML</h2>
        <p>
            Todo documento HTML tiene una raíz <code>&lt;html&gt;</code>, una cabecera
            <code>&lt;head&gt;</code> con metadatos y un cuerpo <code>&lt;body&gt;</code> con el contenido
            visible. El título del <code>&lt;head&gt;</code> aparece en la pestaña del navegador.
        </p>

        <pre><code>&lt;!DOCTYPE html&gt;
&lt;html lang="es"&gt;
    &lt;head&gt;
        &lt;meta charset="UTF-8"&gt;
        &lt;title&gt;Página inicial básica&lt;/title&gt;
    &lt;/head&gt;
    &lt;body&gt;
        Aquí va lo que se va a presentar.
    &lt;/body&gt;
&lt;/html&gt;</code></pre>

        <h3>Encabezados y párrafos</h3>
        <p>
            Los encabezados van de <code>&lt;h1&gt;</code> a <code>&lt;h6&gt;</code> y los párrafos usan
            <code>&lt;p&gt;</code>. Un documento debería tener un solo <code>&lt;h1&gt;</code> principal.
        </p>

        <div class="demo-panel">
            <h3>Ejemplo renderizado</h3>
            <h1>Encabezado de nivel 1</h1>
            <p>Este es un párrafo de ejemplo dentro de un documento HTML.</p>
        </div>

        <pre><code>&lt;h1&gt;Encabezado&lt;/h1&gt;
&lt;p&gt;Este es un párrafo de ejemplo.&lt;/p&gt;</code></pre>

        <h3>Colores con atributos obsoletos</h3>
        <p>
            El ejemplo original usaba <code>bgcolor</code> y <code>text</code> en <code>&lt;body&gt;</code>.
            Esos atributos están obsoletos en HTML5; hoy los colores se definen con CSS.
        </p>

        <pre><code>&lt;!-- Forma antigua, no recomendada --&gt;
&lt;body bgcolor="gray" text="white"&gt;
    &lt;h1&gt;Conceptos de HTML&lt;/h1&gt;
    &lt;p&gt;Este es un párrafo de ejemplo.&lt;/p&gt;
&lt;/body&gt;</code></pre>

        <div class="info-box">
            <strong>Buena práctica:</strong> usa CSS para el color de fondo y del texto. Así el contenido
            queda separado de la presentación.
        </div>
    </section>

    <section class="bloque" id="texto">
        <span class="section-kicker">Lección 02</span>
        <h2>Formatos de texto</h2>
        <p>HTML ofrece etiquetas para resaltar, enfatizar y modificar el texto. Algunas están obsoletas:</p>

        <div class="demo-panel">
            <p>Estilo <b>BOLD</b>: texto en negrita con <code>&lt;b&gt;</code>.</p>
            <p>Estilo <i>ITALIC</i>: texto en cursiva con <code>&lt;i&gt;</code>.</p>
            <p>Estilo <big>BIG</big>: texto grande con <code>&lt;big&gt;</code> (obsoleto).</p>
            <p>Estilo <small>SMALL</small>: texto pequeño con <code>&lt;small&gt;</code>.</p>
            <p>Estilo <strike>STRIKE</strike>: texto tachado con <code>&lt;strike&gt;</code> (obsoleto).</p>
            <p>Estilo <s>S</s>: texto tachado con <code>&lt;s&gt;</code>.</p>
            <p>La etiqueta <code>&lt;br&gt;</code> produce un salto de línea.<br>Esta línea está después del salto.</p>
        </div>

        <pre><code>&lt;b&gt;negrita&lt;/b&gt;
&lt;i&gt;cursiva&lt;/i&gt;
&lt;big&gt;tamaño grande&lt;/big&gt;
&lt;small&gt;tamaño pequeño&lt;/small&gt;
&lt;strike&gt;tachado&lt;/strike&gt;
&lt;s&gt;tachado semántico&lt;/s&gt;
&lt;br&gt;</code></pre>

        <div class="info-box warning-box">
            <strong>Actualización HTML5:</strong> para dar importancia usa <code>&lt;strong&gt;</code> y para
            énfasis usa <code>&lt;em&gt;</code>. Para tamaños, usa CSS <code>font-size</code>.
        </div>
    </section>

    <section class="bloque" id="tablas">
        <span class="section-kicker">Lección 03</span>
        <h2>Tablas</h2>
        <p>
            Una tabla se construye con <code>&lt;table&gt;</code>, filas <code>&lt;tr&gt;</code>, celdas de
            encabezado <code>&lt;th&gt;</code> y celdas de datos <code>&lt;td&gt;</code>. El atributo
            <code>colspan</code> une columnas.
        </p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">Evolución de los sistemas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Año 1960-1970</td><td>El mainframe aloja las tres capas.</td></tr>
                    <tr><td>Año 1970</td><td>Las terminales brindan acceso remoto.</td></tr>
                </tbody>
            </table>
        </div>

        <pre><code>&lt;table border="1"&gt;
    &lt;tr&gt;
        &lt;th colspan="2"&gt;Evolución de los sistemas&lt;/th&gt;
    &lt;/tr&gt;
    &lt;tr&gt;
        &lt;td&gt;Año 1960-1970&lt;/td&gt;
        &lt;td&gt;El mainframe aloja las tres capas.&lt;/td&gt;
    &lt;/tr&gt;
&lt;/table&gt;</code></pre>

        <div class="info-box">
            <strong>Accesibilidad:</strong> usa <code>&lt;caption&gt;</code> para describir la tabla y
            <code>&lt;thead&gt;</code>/<code>&lt;tbody&gt;</code> para organizar su contenido.
        </div>
    </section>

    <section class="bloque" id="imagenes">
        <span class="section-kicker">Lección 04</span>
        <h2>Imágenes y rutas</h2>
        <p>
            La etiqueta <code>&lt;img&gt;</code> carga una imagen mediante <code>src</code>. Siempre debe
            incluir <code>alt</code> para describirla. Las rutas pueden ser relativas o absolutas.
        </p>

        <div class="grid-cards">
            <article class="tarjeta">
                <img class="img-ejemplo" src="<?= url('pages/material/html-basico/pagina6/img/gatoCentrado.jpg') ?>" alt="Gato de ejemplo">
                <h3>Ruta relativa</h3>
                <p><code>img/gatoCentrado.jpg</code> busca la imagen dentro de la carpeta actual.</p>
            </article>
            <article class="tarjeta">
                <img class="img-ejemplo" src="<?= url('pages/material/html-basico/pagina6/img/gato2.jpg') ?>" alt="Segundo gato de ejemplo">
                <h3>Misma carpeta</h3>
                <p><code>./img/gato2.jpg</code> también apunta a una subcarpeta local.</p>
            </article>
        </div>

        <pre><code>&lt;img src="img/gatoCentrado.jpg" width="250" height="250" alt="Gato centrado"&gt;
&lt;img src="./img/gato2.jpg" width="100" height="150" alt="Segundo gato"&gt;</code></pre>

        <div class="info-box warning-box">
            <strong>Obsoleto:</strong> <code>&lt;marquee&gt;</code> y <code>&lt;center&gt;</code> ya no se
            recomiendan. Para animar o centrar usa CSS (<code>animation</code>, <code>margin: auto</code>,
            flexbox o grid).
        </div>
    </section>

    <section class="bloque" id="enlaces">
        <span class="section-kicker">Lección 05</span>
        <h2>Enlaces</h2>
        <p>
            La etiqueta <code>&lt;a&gt;</code> conecta páginas, secciones, correos y recursos externos.
            <code>target="_blank"</code> abre en una pestaña nueva; acompáñalo de
            <code>rel="noopener"</code> por seguridad.
        </p>

        <span id="inicio-enlaces"></span>
        <div class="page-actions">
            <a class="boton" href="#inicio-enlaces">Ir al inicio de esta sección</a>
            <a class="boton boton-secundario" href="#fin-enlaces">Ir al final de esta sección</a>
            <a class="boton boton-secundario" href="mailto:<?= e(APP_CORREO) ?>">Correo institucional</a>
            <a class="boton boton-secundario" href="<?= e(APP_UNIVERSIDAD) ?>" target="_blank" rel="noopener">Mi universidad</a>
        </div>

        <pre><code>&lt;a href="#fin-enlaces"&gt;Ir al final&lt;/a&gt;
&lt;a href="mailto:correo@ejemplo.com"&gt;Escribir&lt;/a&gt;
&lt;a href="https://www.unimayor.edu.co" target="_blank" rel="noopener"&gt;Mi universidad&lt;/a&gt;</code></pre>

        <p id="fin-enlaces">
            Los enlaces internos usan el identificador de un elemento como destino. Los enlaces externos
            llevan una URL completa. Los enlaces de correo usan el esquema <code>mailto:</code>.
        </p>
    </section>

    <section class="bloque" id="listas">
        <span class="section-kicker">Lección 06</span>
        <h2>Listas ordenadas, desordenadas y anidadas</h2>
        <p>
            <code>&lt;ol&gt;</code> crea listas numeradas, <code>&lt;ul&gt;</code> listas con viñetas y
            <code>&lt;li&gt;</code> cada elemento. Se pueden anidar para representar jerarquías.
        </p>

        <div class="grid-cards">
            <article class="tarjeta">
                <h3>Lista ordenada</h3>
                <ol>
                    <li>Analizar el problema.</li>
                    <li>Diseñar la solución.</li>
                    <li>Programar y probar.</li>
                </ol>
            </article>
            <article class="tarjeta">
                <h3>Lista desordenada</h3>
                <ul>
                    <li>HTML</li>
                    <li>CSS</li>
                    <li>JavaScript</li>
                </ul>
            </article>
            <article class="tarjeta">
                <h3>Lista anidada</h3>
                <ul>
                    <li>Frontend
                        <ol>
                            <li>HTML</li>
                            <li>CSS</li>
                        </ol>
                    </li>
                    <li>Backend
                        <ol>
                            <li>PHP</li>
                            <li>Python</li>
                        </ol>
                    </li>
                </ul>
            </article>
        </div>

        <pre><code>&lt;ul&gt;
    &lt;li&gt;Frontend
        &lt;ol&gt;
            &lt;li&gt;HTML&lt;/li&gt;
            &lt;li&gt;CSS&lt;/li&gt;
        &lt;/ol&gt;
    &lt;/li&gt;
    &lt;li&gt;Backend&lt;/li&gt;
&lt;/ul&gt;</code></pre>
    </section>

    <section class="bloque" id="carrusel">
        <span class="section-kicker">Lección 07</span>
        <h2>Carrusel con Bootstrap</h2>
        <p>
            Un carrusel muestra varias imágenes en el mismo espacio. Bootstrap lo construye con
            <code>.carousel</code>, <code>.carousel-inner</code> y <code>.carousel-item</code>.
        </p>

        <div id="carruselMaterial" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3500">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= url('pages/material/html-basico/pagina5/img/slide1.jpg') ?>" class="d-block w-100" alt="Avión 1">
                </div>
                <div class="carousel-item">
                    <img src="<?= url('pages/material/html-basico/pagina5/img/slide2.jpg') ?>" class="d-block w-100" alt="Avión 2">
                </div>
                <div class="carousel-item">
                    <img src="<?= url('pages/material/html-basico/pagina5/img/slide3.jpg') ?>" class="d-block w-100" alt="Avión 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carruselMaterial" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carruselMaterial" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>

        <pre><code>&lt;div id="carouselExample" class="carousel slide" data-bs-ride="carousel"&gt;
    &lt;div class="carousel-inner"&gt;
        &lt;div class="carousel-item active"&gt;
            &lt;img src="img/slide1.jpg" class="d-block w-100" alt="Avión 1"&gt;
        &lt;/div&gt;
        &lt;div class="carousel-item"&gt;
            &lt;img src="img/slide2.jpg" class="d-block w-100" alt="Avión 2"&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
    </section>

    <section class="bloque" id="css">
        <span class="section-kicker">Lección 08</span>
        <h2>Primer contacto con CSS</h2>
        <p>
            CSS permite definir colores, tamaños y tipografías sin repetir atributos en cada etiqueta.
            El siguiente ejemplo usa un bloque <code>&lt;style&gt;</code> interno.
        </p>

        <pre><code>&lt;style&gt;
    h1 { color: blue; font-size: 36px; }
    h2 { color: green; font-size: 30px; }
    h4 { color: orange; font-size: 24px; }
    p  { color: white; font-size: 18px; }
&lt;/style&gt;

&lt;h1&gt;CSS cascade style sheets&lt;/h1&gt;
&lt;p&gt;CSS separa el contenido de la presentación.&lt;/p&gt;</code></pre>

        <div class="demo-panel demo-css-material">
            <h1>CSS cascade style sheets</h1>
            <p>CSS separa el contenido de la presentación y facilita el mantenimiento del sitio.</p>
            <h2>HTML</h2>
            <h4>JavaScript</h4>
            <h2>PHP</h2>
            <h4>Python</h4>
        </div>

        <div class="info-box">
            <strong>Recomendación:</strong> en proyectos reales usa una hoja externa con
            <code>&lt;link rel="stylesheet"&gt;</code> para reutilizar los estilos.
        </div>
    </section>

    <section class="bloque" id="teoria">
        <span class="section-kicker">Lección 09</span>
        <h2>Teoría web: evolución de los sistemas</h2>
        <p>
            Los ejercicios originales también recorrían la historia de la computación. Puedes ampliar
            este tema en la página de conceptos del módulo web.
        </p>

        <div class="grid-cards">
            <article class="tarjeta">
                <img class="img-ejemplo" src="<?= url('pages/material/html-basico/pagina9/img/mainframe.jpg') ?>" alt="Mainframe">
                <h3>Mainframe</h3>
                <p>Computador central de gran capacidad, popular en los años 60.</p>
            </article>
            <article class="tarjeta">
                <img class="img-ejemplo" src="<?= url('pages/material/html-basico/pagina9/img/terminaltonta.jpeg') ?>" alt="Terminal bruta">
                <h3>Terminal bruta</h3>
                <p>Dispositivo sin procesamiento propio que depende del computador central.</p>
            </article>
            <article class="tarjeta">
                <img class="img-ejemplo" src="<?= url('pages/material/html-basico/pagina9/img/clienteservidor.jpg') ?>" alt="Cliente servidor">
                <h3>Cliente-servidor</h3>
                <p>El cliente solicita y el servidor responde a través de una red.</p>
            </article>
            <article class="tarjeta">
                <img class="img-ejemplo" src="<?= url('pages/material/html-basico/pagina9/img/clienteservidormulti.gif') ?>" alt="Cliente servidor multinivel">
                <h3>Multinivel</h3>
                <p>La aplicación se organiza en capas independientes y especializadas.</p>
            </article>
        </div>

        <div class="page-actions">
            <a class="boton" href="<?= url('pages/web/conceptos.php') ?>">Ver la línea de tiempo completa</a>
        </div>
    </section>

    <section class="bloque">
        <h2>Ejercicios propuestos</h2>
        <ol>
            <li>Crea un documento con un <code>&lt;h1&gt;</code>, dos párrafos y una lista desordenada.</li>
            <li>Construye una tabla con tres filas y dos columnas sobre tus lenguajes favoritos.</li>
            <li>Agrega una imagen con texto alternativo y una ruta relativa.</li>
            <li>Enlaza dos secciones de la misma página con identificadores.</li>
            <li>Aplica estilos a los títulos con un bloque <code>&lt;style&gt;</code>.</li>
        </ol>
        <div class="success-box">
            <strong>Entrega:</strong> guarda el ejercicio en un archivo <code>.html</code> y valida que
            abra correctamente en el navegador antes de entregarlo.
        </div>
    </section>
</main>

<style>
    .img-ejemplo {
        width: 100%;
        max-height: 180px;
        object-fit: cover;
        margin-bottom: 0.8rem;
        border: 1px solid var(--borde);
        border-radius: 10px;
    }

    .demo-css-material h1 {
        color: #6ea8ff;
        font-size: clamp(1.6rem, 4vw, 2.2rem);
    }

    .demo-css-material h2 {
        color: #7ee2c4;
        font-size: clamp(1.3rem, 3vw, 1.7rem);
    }

    .demo-css-material h4 {
        color: var(--naranja-claro);
        font-size: 1.1rem;
    }

    .demo-css-material p {
        color: var(--texto-suave);
    }
</style>

<?php require __DIR__ . '/../../../includes/footer.php'; ?>
