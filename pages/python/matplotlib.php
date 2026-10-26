<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'CSV y Matplotlib';
$descripcion = 'Leer un CSV con pandas y convertirlo en gráficas con Matplotlib.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

$galeria = [
    ['archivo' => 'grafico_barras_agrupadas.png', 'titulo' => 'Barras agrupadas', 'texto' => 'Ventas por producto y mes. Ideal para comparar dos dimensiones a la vez.'],
    ['archivo' => 'grafico_lineas.png', 'titulo' => 'Líneas', 'texto' => 'Evolución mensual de las ventas totales.'],
    ['archivo' => 'grafico_barras.png', 'titulo' => 'Barras', 'texto' => 'Ventas totales por producto con etiquetas de valor.'],
    ['archivo' => 'grafico_torta.png', 'titulo' => 'Torta', 'texto' => 'Participación de cada producto en el total.'],
    ['archivo' => 'histograma_ventas.png', 'titulo' => 'Histograma', 'texto' => 'Distribución de las ventas en rangos (bins).'],
    ['archivo' => 'grafico_dispersion.png', 'titulo' => 'Dispersión', 'texto' => 'Relación entre costos y ventas, con línea de tendencia.'],
    ['archivo' => 'panel_ventas.png', 'titulo' => 'Panel 2×2', 'texto' => 'Varias gráficas en una sola figura con subplots.'],
    ['archivo' => 'ejercicio_ganancia.png', 'titulo' => 'Ejercicio: ganancia', 'texto' => 'Ganancia por mes calculada como ventas menos costos.'],
    ['archivo' => 'ejercicio_barras_horizontal.png', 'titulo' => 'Ejercicio: barras horizontales', 'texto' => 'Comparación de ventas totales por producto.'],
];

$ventas = [
    ['mes' => 'Enero', 'laptop' => 12000, 'celular' => 9000, 'tablet' => 5000],
    ['mes' => 'Febrero', 'laptop' => 15000, 'celular' => 11000, 'tablet' => 6000],
    ['mes' => 'Marzo', 'laptop' => 17000, 'celular' => 13000, 'tablet' => 7500],
    ['mes' => 'Abril', 'laptop' => 16000, 'celular' => 14000, 'tablet' => 8000],
];
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de Python · 06</span>
        <h1>De un CSV a una gráfica con Matplotlib</h1>
        <p>
            Un archivo CSV guarda datos en texto plano separados por comas. Con
            <code>pandas</code> se convierte en una tabla manejable y con
            <code>matplotlib</code> se transforma en imágenes listas para un reporte.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/python/analisis-datos.php') ?>">Siguiente: análisis climático</a>
            <a class="boton boton-secundario" href="<?= url('pages/python/graficas.php') ?>">Volver a gráficas</a>
        </div>
    </header>

    <section class="bloque">
        <h2>1. ¿Qué es un archivo CSV?</h2>
        <p>
            Es una tabla en texto plano: la primera línea contiene los encabezados y cada línea
            siguiente es un registro. Se abre con Excel, Google Sheets o cualquier editor.
        </p>

        <pre><code>Mes,Producto,Ventas,Costos
Enero,Laptop,12000,8000
Febrero,Laptop,15000,9000
Marzo,Laptop,17000,10000
Abril,Laptop,16000,9500</code></pre>

        <div class="info-box">
            <strong>Ventaja:</strong> al ser texto, un CSV es liviano, portable y fácil de generar
            desde una base de datos o una API. Es el formato de intercambio más común en analítica.
        </div>
    </section>

    <section class="bloque">
        <h2>2. Leer el CSV con pandas</h2>
        <pre><code>import pandas as pd

df = pd.read_csv("ventas.csv")

print(df.head())     # primeras filas
print(df.info())     # tipos y valores nulos
print(df.describe()) # estadísticas</code></pre>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th>Laptop</th>
                        <th>Celular</th>
                        <th>Tablet</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $fila): ?>
                        <tr>
                            <td><?= e($fila['mes']) ?></td>
                            <td>$<?= e(number_format($fila['laptop'], 0, ',', '.')) ?></td>
                            <td>$<?= e(number_format($fila['celular'], 0, ',', '.')) ?></td>
                            <td>$<?= e(number_format($fila['tablet'], 0, ',', '.')) ?></td>
                            <td><strong>$<?= e(number_format($fila['laptop'] + $fila['celular'] + $fila['tablet'], 0, ',', '.')) ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="bloque">
        <h2>3. Explorar y limpiar</h2>
        <pre><code># Valores nulos por columna
print(df.isnull().sum())

# Eliminar filas incompletas
df = df.dropna()

# Columna calculada
df["Ganancia"] = df["Ventas"] - df["Costos"]

# Agrupar y sumar
ventas_producto = df.groupby("Producto")["Ventas"].sum()
ventas_mes = df.groupby("Mes")["Ventas"].sum()</code></pre>

        <ul class="lista-caracteristicas">
            <li><code>head()</code> muestra las primeras filas.</li>
            <li><code>info()</code> revela tipos de datos y nulos.</li>
            <li><code>describe()</code> resume media, mínimo, máximo y cuartiles.</li>
            <li><code>groupby()</code> agrupa por una columna y permite sumar, promediar o contar.</li>
            <li><code>dropna()</code> elimina registros incompletos.</li>
        </ul>
    </section>

    <section class="bloque">
        <h2>4. Gráfica de líneas con Matplotlib</h2>
        <pre><code>import matplotlib.pyplot as plt

plt.figure(figsize=(8, 5))
plt.plot(ventas_mes.index, ventas_mes.values,
         marker="o", color="steelblue", linewidth=2)

plt.title("Evolución de ventas por mes")
plt.xlabel("Mes")
plt.ylabel("Ventas ($)")
plt.grid(True, linestyle="--", alpha=0.6)
plt.tight_layout()
plt.savefig("grafico_lineas.png", dpi=150)
plt.show()</code></pre>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Función</th>
                        <th>Para qué sirve</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><code>figure()</code></td><td>Define el tamaño del lienzo.</td></tr>
                    <tr><td><code>plot()</code></td><td>Dibuja líneas y puntos.</td></tr>
                    <tr><td><code>bar()</code></td><td>Dibuja barras verticales.</td></tr>
                    <tr><td><code>pie()</code></td><td>Dibuja una torta de participaciones.</td></tr>
                    <tr><td><code>hist()</code></td><td>Agrupa valores en rangos y cuenta frecuencias.</td></tr>
                    <tr><td><code>scatter()</code></td><td>Ubica puntos según dos variables.</td></tr>
                    <tr><td><code>savefig()</code></td><td>Guarda la imagen en disco.</td></tr>
                    <tr><td><code>show()</code></td><td>Muestra la ventana con la gráfica.</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="bloque">
        <h2>5. Galería de resultados</h2>
        <p>Estas imágenes fueron generadas por los scripts de la clase a partir del archivo <code>ventas.csv</code>.</p>

        <div class="gallery-grid">
            <?php foreach ($galeria as $imagen): ?>
                <figure class="gallery-item">
                    <img src="<?= url('assets/img/matplotlib/' . $imagen['archivo']) ?>"
                        alt="<?= e($imagen['titulo']) ?>" loading="lazy">
                    <figcaption>
                        <strong><?= e($imagen['titulo']) ?>.</strong>
                        <?= e($imagen['texto']) ?>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="bloque">
        <h2>6. Ejercicios propuestos</h2>
        <ol class="pasos">
            <li class="paso">
                <span class="paso-numero">1</span>
                <h3>Ganancia por mes</h3>
                <p>Crea la columna <code>Ganancia = Ventas - Costos</code> y grafícala con barras.</p>
            </li>
            <li class="paso">
                <span class="paso-numero">2</span>
                <h3>Barras horizontales</h3>
                <p>Compara las ventas totales por producto con <code>barh()</code>.</p>
            </li>
            <li class="paso">
                <span class="paso-numero">3</span>
                <h3>Ventas frente a costos</h3>
                <p>Dibuja una dispersión y añade una línea de tendencia con <code>numpy.polyfit()</code>.</p>
            </li>
        </ol>

        <pre><code># Solución del ejercicio 1
ganancia_mes = df.groupby("Mes")["Ganancia"].sum()

plt.figure(figsize=(8, 5))
plt.bar(ganancia_mes.index, ganancia_mes.values, color="#38b2a3")
plt.title("Ganancia por mes")
plt.xlabel("Mes")
plt.ylabel("Ganancia ($)")
plt.tight_layout()
plt.savefig("ejercicio_ganancia.png", dpi=150)
plt.show()</code></pre>

        <div class="nota">
            <strong>Los scripts completos están en el proyecto:</strong>
            <code>python/clase_csv_matplotlib/</code>, junto con <code>ventas.csv</code> y
            <code>resumen.csv</code>. Ejecuta <code>python graficos_csv.py</code> dentro de esa carpeta.
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
