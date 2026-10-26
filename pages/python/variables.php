<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Variables en Python';
$descripcion = 'Variables, tipos de datos y operaciones básicas en Python.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

$tipos = [
    ['tipo' => 'str', 'ejemplo' => '"Ana"', 'descripcion' => 'Texto entre comillas simples o dobles.'],
    ['tipo' => 'int', 'ejemplo' => '25', 'descripcion' => 'Números enteros, positivos o negativos.'],
    ['tipo' => 'float', 'ejemplo' => '19.99', 'descripcion' => 'Números con decimales.'],
    ['tipo' => 'bool', 'ejemplo' => 'True / False', 'descripcion' => 'Valores lógicos.'],
    ['tipo' => 'list', 'ejemplo' => '["pan", "leche"]', 'descripcion' => 'Colección ordenada y modificable.'],
    ['tipo' => 'dict', 'ejemplo' => '{"nombre": "Carlos"}', 'descripcion' => 'Colección de pares clave-valor.'],
    ['tipo' => 'NoneType', 'ejemplo' => 'None', 'descripcion' => 'Ausencia de valor.'],
];
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de Python · 02</span>
        <h1>Variables y tipos de datos</h1>
        <p>
            Una variable es un nombre que apunta a un valor guardado en memoria. En Python no se
            declara el tipo: se crea en el momento en que se asigna con el signo <code>=</code>.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/python/operadores.php') ?>">Siguiente: operadores</a>
            <a class="boton boton-secundario" href="<?= url('pages/python/index.php') ?>">Volver a conceptos</a>
        </div>
    </header>

    <section class="bloque">
        <h2>Sintaxis básica</h2>
        <pre><code>nombre_variable = valor

edad = 25
print(edad)  # 25</code></pre>

        <div class="info-box">
            <strong>Regla de oro:</strong> el nombre debe empezar con una letra o guion bajo, no puede
            contener espacios y distingue mayúsculas de minúsculas. <code>edad</code> y <code>Edad</code>
            son variables diferentes.
        </div>
    </section>

    <section class="bloque">
        <h2>Tipos de variables comunes</h2>

        <h3>Textos (strings)</h3>
        <pre><code>nombre = "Ana"
ciudad = 'Madrid'
mensaje = f"Hola, {nombre}"</code></pre>

        <h3>Números (enteros y decimales)</h3>
        <pre><code>precio = 19.99
cantidad = 3
anio_actual = 2026
total = precio * cantidad  # 59.97</code></pre>

        <h3>Booleanos</h3>
        <pre><code>es_mayor_de_edad = True
tiene_descuento = False</code></pre>

        <h3>Colecciones</h3>
        <pre><code>lista_compras = ["manzana", "pan", "leche"]
usuario = {"nombre": "Carlos", "id": 1024}
coordenadas = (2.4448, -76.6147)</code></pre>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Ejemplo</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tipos as $tipo): ?>
                        <tr>
                            <td><code><?= e($tipo['tipo']) ?></code></td>
                            <td><code><?= e($tipo['ejemplo']) ?></code></td>
                            <td><?= e($tipo['descripcion']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="bloque">
        <h2>Operaciones rápidas</h2>

        <h3>Modificar el valor</h3>
        <pre><code>contador = 1
contador = contador + 1  # ahora vale 2</code></pre>

        <h3>Sumar variables numéricas</h3>
        <pre><code>producto_a = 10
producto_b = 20
total = producto_a + producto_b

print(total)  # 30</code></pre>

        <h3>Unir textos</h3>
        <pre><code>nombre = "Ana"
saludo = "Hola " + nombre

print(saludo)  # Hola Ana</code></pre>

        <h3>Convertir tipos (casting)</h3>
        <pre><code>entero = int("25")      # 25
decimal = float(10)     # 10.0
texto = str(4.5)        # "4.5"</code></pre>
    </section>

    <section class="bloque">
        <h2>Ejemplo completo</h2>
        <p>Un pequeño programa que calcula el total de una compra e imprime un resumen:</p>

        <pre><code>producto = "Cuaderno"
precio = 4500
cantidad = 3
descuento = 0.10

subtotal = precio * cantidad
total = subtotal - (subtotal * descuento)

print(f"Producto: {producto}")
print(f"Subtotal: ${subtotal}")
print(f"Total con descuento: ${total:.0f}")</code></pre>

        <div class="demo-panel">
            <h3>Salida esperada</h3>
            <pre><code>Producto: Cuaderno
Subtotal: $13500
Total con descuento: $12150</code></pre>
            <p class="small-note">
                El formato <code>:.0f</code> muestra el número sin decimales. Para dos decimales usa
                <code>:.2f</code>.
            </p>
        </div>
    </section>

    <section class="bloque">
        <h2>Buenas prácticas</h2>
        <ul class="lista-caracteristicas">
            <li>Usa nombres descriptivos: <code>total_compra</code> es mejor que <code>t</code>.</li>
            <li>Escribe los nombres en minúsculas y separa palabras con guion bajo (<em>snake_case</em>).</li>
            <li>No reutilices el mismo nombre para valores de distinto significado.</li>
            <li>Comenta solo lo que no sea evidente por sí mismo.</li>
            <li>Usa <code>f-strings</code> para combinar texto y variables.</li>
        </ul>

        <div class="warning-box">
            <strong>Ojo con la indentación:</strong> Python usa espacios al inicio de la línea para saber
            qué instrucciones pertenecen a un bloque. Mezclar tabulaciones y espacios produce errores
            difíciles de encontrar.
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
