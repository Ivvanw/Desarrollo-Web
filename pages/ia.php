<?php
require_once __DIR__ . '/../config/auth.php';
requerirLogin();

$titulo = 'Inteligencia artificial';
$descripcion = 'Conceptos de inteligencia artificial, machine learning y su relación con el desarrollo web.';
require __DIR__ . '/../includes/head.php';
require __DIR__ . '/../includes/header.php';

$nombreUsuario = $_SESSION['nombre'] ?? 'estudiante';
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Módulo complementario</span>
        <h1>Inteligencia artificial y desarrollo web</h1>
        <p>
            Hola, <strong><?= e($nombreUsuario) ?></strong>. La inteligencia artificial (IA) ya no es solo
            un tema de laboratorio: aparece en asistentes de código, buscadores, recomendaciones,
            chatbots y herramientas de diseño. Entender sus conceptos te ayuda a usarla con criterio.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/material/index.php') ?>">Ir al material</a>
            <a class="boton boton-secundario" href="<?= url('inicio.php') ?>">Volver al inicio</a>
        </div>
    </header>

    <section class="bloque">
        <h2>¿Qué es la inteligencia artificial?</h2>
        <p>
            La IA es el conjunto de técnicas que permiten a una máquina realizar tareas que normalmente
            requieren inteligencia humana: reconocer imágenes, entender lenguaje, recomendar contenido,
            predecir valores o tomar decisiones. No es magia: son modelos matemáticos entrenados con datos.
        </p>

        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🧠</span>
                <h3>IA</h3>
                <p>Campo amplio que busca simular capacidades cognitivas humanas.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">📊</span>
                <h3>Machine learning</h3>
                <p>Algoritmos que aprenden patrones a partir de datos, sin programar cada regla.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🕸️</span>
                <h3>Deep learning</h3>
                <p>Redes neuronales con muchas capas para tareas complejas como visión y lenguaje.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">💬</span>
                <h3>IA generativa</h3>
                <p>Modelos que producen texto, imágenes, audio o código a partir de una instrucción.</p>
            </article>
        </div>

        <div class="info-box">
            <strong>Importante:</strong> IA, machine learning y deep learning no son sinónimos. El machine
            learning es una técnica dentro de la IA, y el deep learning es una técnica dentro del machine learning.
        </div>
    </section>

    <section class="bloque">
        <h2>IA en el desarrollo web</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Área</th>
                        <th>Uso típico</th>
                        <th>Ejemplo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Asistentes de código</td><td>Autocompletar, explicar y corregir código.</td><td>Sugerir una función PHP.</td></tr>
                    <tr><td>Contenido</td><td>Redactar borradores y resumir textos.</td><td>Descripciones de productos.</td></tr>
                    <tr><td>Atención al cliente</td><td>Responder preguntas frecuentes.</td><td>Chatbot de soporte.</td></tr>
                    <tr><td>Recomendación</td><td>Personalizar lo que ve cada usuario.</td><td>Películas o cursos sugeridos.</td></tr>
                    <tr><td>Análisis</td><td>Detectar patrones y anomalías.</td><td>Alertas de fraude.</td></tr>
                    <tr><td>Accesibilidad</td><td>Generar subtítulos o describir imágenes.</td><td>Texto alternativo automático.</td></tr>
                </tbody>
            </table>
        </div>

        <h3>Buenas prácticas al usar IA</h3>
        <ul class="lista-caracteristicas">
            <li><strong>Verifica:</strong> los modelos pueden inventar datos o citar fuentes falsas.</li>
            <li><strong>No compartas secretos:</strong> evita pegar contraseñas, datos personales o claves.</li>
            <li><strong>Revisa el código:</strong> la IA acelera, pero la responsabilidad final es tuya.</li>
            <li><strong>Respeta licencias:</strong> comprueba el origen del contenido generado.</li>
            <li><strong>Sé transparente:</strong> indica cuándo un contenido fue asistido por IA.</li>
        </ul>
    </section>

    <section class="bloque">
        <h2>Ejemplo: clasificador sencillo con JavaScript</h2>
        <p>
            Este ejemplo no usa un modelo entrenado: aplica reglas simples para clasificar un mensaje.
            Sirve para entender la idea de <em>entrada → procesamiento → salida</em>.
        </p>

        <pre><code>function clasificar(mensaje) {
    const texto = mensaje.toLowerCase();

    if (texto.includes('error') || texto.includes('falla')) {
        return 'Posible problema técnico';
    }

    if (texto.includes('precio') || texto.includes('comprar')) {
        return 'Consulta comercial';
    }

    return 'Consulta general';
}</code></pre>

        <div class="demo-panel">
            <h3>Prueba el clasificador</h3>
            <label for="mensajeIa">Escribe un mensaje</label>
            <div class="search-row">
                <input type="text" id="mensajeIa" placeholder="Ejemplo: la app muestra un error">
                <button id="clasificarIa" type="button">Clasificar</button>
            </div>
            <p id="resultadoIa" class="demo-result" aria-live="polite">El resultado aparecerá aquí.</p>
        </div>
    </section>

    <section class="bloque">
        <h2>Prompt engineering: pedir bien</h2>
        <p>Un buen prompt reduce la ambigüedad. Compara estos dos ejemplos:</p>

        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">❌</span>
                <h3>Prompt débil</h3>
                <p>«Hazme una página web». No indica público, contenido ni restricciones.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">✅</span>
                <h3>Prompt claro</h3>
                <p>«Crea una página HTML5 responsive para un restaurante, con menú, horario y formulario de reserva».</p>
            </article>
        </div>

        <div class="success-box">
            <strong>Estructura recomendada:</strong> rol + tarea + contexto + formato + restricciones.
            Si el resultado no sirve, pide ajustes concretos en lugar de repetir la misma instrucción.
        </div>
    </section>

    <section class="bloque">
        <h2>Retos y límites</h2>
        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">⚖️</span>
                <h3>Sesgos</h3>
                <p>Si los datos de entrenamiento son injustos, las respuestas pueden reproducir esa injusticia.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🔒</span>
                <h3>Privacidad</h3>
                <p>Los datos enviados a un servicio externo pueden quedar almacenados o ser usados para entrenar.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">💸</span>
                <h3>Costos</h3>
                <p>Las APIs de IA cobran por uso; conviene medir y limitar las peticiones.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🧑‍⚖️</span>
                <h3>Responsabilidad</h3>
                <p>Una persona debe revisar las decisiones automatizadas que afectan a otras personas.</p>
            </article>
        </div>
    </section>
</main>

<script>
    const mensajeIa = document.getElementById('mensajeIa');
    const resultadoIa = document.getElementById('resultadoIa');
    const clasificarIa = document.getElementById('clasificarIa');

    function clasificar(mensaje) {
        const texto = mensaje.toLowerCase();

        if (texto.includes('error') || texto.includes('falla') || texto.includes('roto')) {
            return 'Posible problema técnico';
        }

        if (texto.includes('precio') || texto.includes('comprar') || texto.includes('pago')) {
            return 'Consulta comercial';
        }

        if (texto.includes('hola') || texto.includes('gracias')) {
            return 'Saludo o agradecimiento';
        }

        return 'Consulta general';
    }

    clasificarIa.addEventListener('click', () => {
        const mensaje = mensajeIa.value.trim();

        if (!mensaje) {
            resultadoIa.textContent = 'Escribe un mensaje para clasificarlo.';
            return;
        }

        resultadoIa.textContent = 'Categoría: ' + clasificar(mensaje);
    });

    mensajeIa.addEventListener('keydown', event => {
        if (event.key === 'Enter') {
            clasificarIa.click();
        }
    });
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>
