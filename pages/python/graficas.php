<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Gráficas con Chart.js';
$descripcion = 'Barras, líneas y dona para contar historias con datos.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de Python · 05</span>
        <h1>Gráficas: primero la pregunta, después el gráfico</h1>
        <p>
            Una gráfica no es decoración: responde una pregunta. Antes de elegir el tipo, decide
            si quieres comparar, mostrar una evolución o explicar una composición.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/python/matplotlib.php') ?>">Siguiente: CSV y Matplotlib</a>
            <a class="boton boton-secundario" href="<?= url('pages/python/comandos.php') ?>">Volver a comandos</a>
        </div>
    </header>

    <section class="bloque">
        <h2>Elige el gráfico según la pregunta</h2>
        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">📊</span>
                <h3>¿Cómo se comparan?</h3>
                <p>Barras. Compara categorías con una misma escala.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">📈</span>
                <h3>¿Cómo cambia en el tiempo?</h3>
                <p>Líneas. Muestra tendencias y estacionalidad.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🍩</span>
                <h3>¿Cómo se reparte el total?</h3>
                <p>Dona o torta. Úsala con pocas categorías.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🔵</span>
                <h3>¿Hay relación?</h3>
                <p>Dispersión. Busca correlación entre dos variables.</p>
            </article>
        </div>
    </section>

    <section class="bloque">
        <h2>Comparación: ventas por zona</h2>
        <p>Pregunta: <em>¿qué zona vendió más el último trimestre?</em></p>
        <div class="lienzo-grafica">
            <canvas id="graficoBarras" aria-label="Ventas por zona" role="img"></canvas>
        </div>
    </section>

    <section class="bloque">
        <h2>Evolución: ventas del año</h2>
        <p>Pregunta: <em>¿cómo se comportaron las ventas mes a mes?</em></p>
        <div class="lienzo-grafica">
            <canvas id="graficoLineas" aria-label="Evolución mensual de ventas" role="img"></canvas>
        </div>
    </section>

    <section class="bloque">
        <h2>Composición: categorías de producto</h2>
        <p>Pregunta: <em>¿qué parte del catálogo corresponde a cada línea?</em></p>
        <div class="lienzo-grafica lienzo-dona">
            <canvas id="graficoDona" aria-label="Composición por categoría" role="img"></canvas>
        </div>
    </section>

    <section class="bloque">
        <h2>Código mínimo con Chart.js</h2>
        <p>
            Chart.js dibuja sobre un <code>&lt;canvas&gt;</code>. Se incluye la librería, se obtiene
            el contexto y se crea una instancia con <code>type</code>, <code>data</code> y
            <code>options</code>.
        </p>

        <pre><code>&lt;canvas id="miGrafica"&gt;&lt;/canvas&gt;

&lt;script src="https://cdn.jsdelivr.net/npm/chart.js"&gt;&lt;/script&gt;
&lt;script&gt;
new Chart(document.getElementById('miGrafica'), {
    type: 'bar',
    data: {
        labels: ['Centro', 'Norte', 'Sur'],
        datasets: [{
            label: 'Ventas (millones)',
            data: [128, 112, 97],
            backgroundColor: '#4c8dff',
            borderRadius: 4
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
&lt;/script&gt;</code></pre>

        <div class="info-box">
            <strong>Accesibilidad:</strong> añade <code>aria-label</code> y <code>role="img"</code> al
            canvas, y acompaña siempre la gráfica con una frase que explique lo que muestra.
        </div>
    </section>

    <section class="bloque">
        <h2>Cómo leer una gráfica sin engañarte</h2>
        <ul class="lista-caracteristicas">
            <li>Revisa si el eje vertical empieza en cero; un recorte exagera las diferencias.</li>
            <li>Compara unidades iguales: no mezcles miles con millones.</li>
            <li>Desconfía de una gráfica de torta con más de cinco categorías.</li>
            <li>Una línea necesita al menos tres puntos para insinuar una tendencia.</li>
            <li>La fuente y el periodo de los datos son parte de la gráfica.</li>
        </ul>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";
    Chart.defaults.color = '#aab4c2';
    Chart.defaults.maintainAspectRatio = false;

    const gridColor = 'rgba(35, 43, 54, 0.85)';

    new Chart(document.getElementById('graficoBarras'), {
        type: 'bar',
        data: {
            labels: ['Centro', 'Norte', 'Sur', 'Oriente', 'Occidente'],
            datasets: [{
                label: 'Ventas vs meta (millones)',
                data: [128, 112, 97, 84, 71],
                backgroundColor: '#4c8dff',
                borderRadius: 5
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: gridColor } },
                x: { grid: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('graficoLineas'), {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [{
                label: 'Ventas 2026',
                data: [62, 60, 68, 72, 76, 74, 80, 82, 86, 92, 110, 128],
                borderColor: '#f0a43a',
                borderWidth: 2,
                backgroundColor: 'rgba(240, 164, 58, 0.14)',
                pointBackgroundColor: '#ffd08a',
                tension: 0.32,
                fill: true
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, grid: { color: gridColor } },
                x: { grid: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('graficoDona'), {
        type: 'doughnut',
        data: {
            labels: ['Ropa', 'Calzado', 'Accesorios'],
            datasets: [{
                data: [60, 34, 26],
                backgroundColor: ['#4c8dff', '#38b2a3', '#f0a43a'],
                borderColor: '#0f1319',
                borderWidth: 3
            }]
        },
        options: {
            cutout: '58%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 18, usePointStyle: true } }
            }
        }
    });
</script>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
