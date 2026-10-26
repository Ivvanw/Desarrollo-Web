<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Operadores en Python';
$descripcion = 'Operadores aritméticos, de comparación, lógicos y de asignación.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

$a = 7;
$b = 5;
$resultados = [
    ['operador' => '+', 'nombre' => 'Suma', 'expresion' => 'a + b', 'valor' => $a + $b],
    ['operador' => '-', 'nombre' => 'Resta', 'expresion' => 'a - b', 'valor' => $a - $b],
    ['operador' => '*', 'nombre' => 'Multiplicación', 'expresion' => 'a * b', 'valor' => $a * $b],
    ['operador' => '/', 'nombre' => 'División', 'expresion' => 'a / b', 'valor' => round($a / $b, 4)],
    ['operador' => '//', 'nombre' => 'División entera', 'expresion' => 'a // b', 'valor' => intdiv($a, $b)],
    ['operador' => '%', 'nombre' => 'Módulo (residuo)', 'expresion' => 'a % b', 'valor' => $a % $b],
    ['operador' => '**', 'nombre' => 'Potencia', 'expresion' => 'a ** b', 'valor' => $a ** $b],
];
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de Python · 03</span>
        <h1>Operadores</h1>
        <p>
            Los operadores permiten calcular, comparar valores y combinar condiciones.
            Son la base de cualquier decisión que tome el programa.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/python/comandos.php') ?>">Siguiente: comandos</a>
            <a class="boton boton-secundario" href="<?= url('pages/python/variables.php') ?>">Volver a variables</a>
        </div>
    </header>

    <section class="bloque">
        <h2>Operadores aritméticos</h2>
        <p>Con <code>a = 7</code> y <code>b = 5</code> el resultado de cada operación es:</p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Operador</th>
                        <th>Nombre</th>
                        <th>Expresión</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $fila): ?>
                        <tr>
                            <td><code><?= e($fila['operador']) ?></code></td>
                            <td><?= e($fila['nombre']) ?></td>
                            <td><code><?= e($fila['expresion']) ?></code></td>
                            <td><strong><?= e(str_replace('.', ',', (string) $fila['valor'])) ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <pre><code>a = 7
b = 5

print(a * b)   # 35
print(a + b)   # 12
print(a - b)   # 2
print(a / b)   # 1.4
print(a // b)  # 1
print(a % b)   # 2
print(a ** b)  # 16807

ciudad = "Popayán"
print("Longitud:", len(ciudad))  # 6</code></pre>

        <div class="info-box">
            <strong>Diferencia importante:</strong> <code>/</code> siempre devuelve un decimal y
            <code>//</code> descarta la parte decimal. <code>%</code> devuelve el residuo, muy útil
            para saber si un número es par.
        </div>
    </section>

    <section class="bloque">
        <h2>Operadores de comparación</h2>
        <p>Devuelven <code>True</code> o <code>False</code> y se usan dentro de condicionales y ciclos.</p>

        <pre><code>edad = 20

print(edad == 20)   # Igual a              -&gt; True
print(edad != 18)   # Diferente de         -&gt; True
print(edad &gt; 18)    # Mayor que            -&gt; True
print(edad &lt; 18)    # Menor que            -&gt; False
print(edad &gt;= 20)   # Mayor o igual que    -&gt; True
print(edad &lt;= 19)   # Menor o igual que    -&gt; False</code></pre>

        <div class="warning-box">
            <strong>No confundas:</strong> <code>=</code> asigna un valor y <code>==</code> compara.
            Escribir <code>if edad = 18</code> produce un error de sintaxis.
        </div>
    </section>

    <section class="bloque">
        <h2>Operadores lógicos</h2>
        <pre><code>tiene_cedula = True
es_mayor = 20 &gt;= 18

print(tiene_cedula and es_mayor)  # True si ambas son verdaderas
print(tiene_cedula or es_mayor)   # True si al menos una es verdadera
print(not tiene_cedula)           # Invierte el valor -&gt; False</code></pre>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Operador</th>
                        <th>Se lee</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>and</code></td>
                        <td>y</td>
                        <td>True solo si ambas condiciones son verdaderas.</td>
                    </tr>
                    <tr>
                        <td><code>or</code></td>
                        <td>o</td>
                        <td>True si al menos una condición es verdadera.</td>
                    </tr>
                    <tr>
                        <td><code>not</code></td>
                        <td>no</td>
                        <td>Invierte el valor lógico.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="bloque">
        <h2>Operadores de asignación</h2>
        <p>Permiten actualizar una variable sin repetir su nombre dos veces.</p>

        <pre><code>contador = 10

contador += 5   # contador = contador + 5  -&gt; 15
contador -= 3   # contador = contador - 3  -&gt; 12
contador *= 2   # contador = contador * 2  -&gt; 24
contador /= 4   # contador = contador / 4  -&gt; 6.0</code></pre>

        <div class="demo-panel">
            <h3>Simulación paso a paso</h3>
            <div class="data-table">
                <div><strong>Inicio</strong><span>10</span></div>
                <div><strong>+= 5</strong><span>15</span></div>
                <div><strong>-= 3</strong><span>12</span></div>
                <div><strong>*= 2</strong><span>24</span></div>
                <div><strong>/= 4</strong><span>6.0</span></div>
            </div>
        </div>
    </section>

    <section class="bloque">
        <h2>Operadores de pertenencia e identidad</h2>
        <pre><code>frutas = ["manzana", "pera", "uva"]

print("pera" in frutas)      # True
print("mango" not in frutas)  # True

texto = None
print(texto is None)          # True
print(texto is not None)      # False</code></pre>

        <div class="nota">
            <strong>Jerarquía:</strong> Python evalúa primero la aritmética, luego las comparaciones
            y al final los operadores lógicos. Usa paréntesis cuando quieras dejar clara la intención.
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
