<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Comandos en Python';
$descripcion = 'Entrada y salida, condicionales, ciclos, funciones y funciones integradas.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de Python · 04</span>
        <h1>Comandos y estructuras básicas</h1>
        <p>
            Con variables, operadores y unas cuantas estructuras ya se pueden escribir programas
            completos. Aquí están los comandos que aparecerán en casi todos tus ejercicios.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/python/graficas.php') ?>">Siguiente: gráficas</a>
            <a class="boton boton-secundario" href="<?= url('pages/python/operadores.php') ?>">Volver a operadores</a>
        </div>
    </header>

    <section class="bloque">
        <h2>Entrada y salida de datos</h2>
        <p>
            <code>print()</code> muestra información y <code>input()</code> la solicita.
            Ojo: <code>input()</code> siempre devuelve texto.
        </p>

        <pre><code>print("¡Hola, mundo!")

nombre = input("Introduce tu nombre: ")
print(f"Bienvenido, {nombre}")</code></pre>

        <div class="info-box">
            <strong>Para convertir:</strong> si necesitas un número, usa
            <code>int(input("Edad: "))</code> o <code>float(...)</code>.
        </div>
    </section>

    <section class="bloque">
        <h2>Condicionales</h2>
        <pre><code>edad = 20

if edad &gt;= 18:
    print("Mayor de edad")
elif edad &gt;= 12:
    print("Adolescente")
else:
    print("Menor de edad")</code></pre>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Palabra</th>
                        <th>Uso</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>if</code></td>
                        <td>Evalúa la primera condición.</td>
                    </tr>
                    <tr>
                        <td><code>elif</code></td>
                        <td>Evalúa otra condición si la anterior falló.</td>
                    </tr>
                    <tr>
                        <td><code>else</code></td>
                        <td>Se ejecuta cuando ninguna condición se cumplió.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="bloque">
        <h2>Ciclos</h2>

        <h3>Bucle for</h3>
        <p>Repite un bloque un número conocido de veces.</p>
        <pre><code>for i in range(5):
    print(f"Repetición número: {i}")</code></pre>

        <h3>Bucle while</h3>
        <p>Repite mientras la condición sea verdadera.</p>
        <pre><code>contador = 0

while contador &lt; 3:
    print(contador)
    contador += 1</code></pre>

        <div class="demo-panel">
            <h3>Salida del ciclo while</h3>
            <pre><code>0
1
2</code></pre>
        </div>

        <div class="warning-box">
            <strong>Cuidado con el ciclo infinito:</strong> si olvidas actualizar la variable del
            <code>while</code>, el programa nunca termina. Presiona <kbd>Ctrl</kbd> + <kbd>C</kbd>
            en la terminal para detenerlo.
        </div>
    </section>

    <section class="bloque">
        <h2>Funciones integradas comunes</h2>

        <h3>Longitud de un texto o lista</h3>
        <pre><code>longitud = len("Python")   # 6</code></pre>

        <h3>Conocer el tipo de dato</h3>
        <pre><code>tipo = type(10.5)
print(tipo)  # &lt;class 'float'&gt;</code></pre>

        <h3>Conversión de tipos (casting)</h3>
        <pre><code>entero = int("25")
decimal = float(10)
texto = str(4.5)</code></pre>

        <h3>Operaciones matemáticas</h3>
        <pre><code>absoluto = abs(-7)          # 7
redondeado = round(3.14159, 2)  # 3.14
maximo = max(5, 12, 8)      # 12
minimo = min(5, 12, 8)      # 5
suma = sum([1, 2, 3])       # 6</code></pre>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Función</th>
                        <th>Qué hace</th>
                        <th>Ejemplo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><code>len()</code></td><td>Cuenta elementos o caracteres.</td><td><code>len("hola")</code> → 4</td></tr>
                    <tr><td><code>type()</code></td><td>Indica el tipo del valor.</td><td><code>type(3)</code> → int</td></tr>
                    <tr><td><code>int()</code></td><td>Convierte a entero.</td><td><code>int("25")</code></td></tr>
                    <tr><td><code>round()</code></td><td>Redondea con decimales.</td><td><code>round(3.1416, 2)</code></td></tr>
                    <tr><td><code>range()</code></td><td>Genera una secuencia de números.</td><td><code>range(1, 6)</code></td></tr>
                    <tr><td><code>sum()</code></td><td>Suma los valores de una lista.</td><td><code>sum([1, 2, 3])</code></td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="bloque">
        <h2>Funciones propias</h2>
        <p>
            Una función agrupa código reutilizable. Se define con <code>def</code>, recibe parámetros
            y devuelve un resultado con <code>return</code>.
        </p>

        <pre><code>def sumar(a, b):
    resultado = a + b
    return resultado


mi_suma = sumar(5, 10)
print(mi_suma)  # 15</code></pre>

        <h3>Parámetros con valor por defecto</h3>
        <pre><code>def saludar(nombre, saludo="Hola"):
    return f"{saludo}, {nombre}"

print(saludar("Ana"))           # Hola, Ana
print(saludar("Ana", "Buen día"))  # Buen día, Ana</code></pre>

        <div class="info-box">
            <strong>Buenas prácticas:</strong> usa verbos para nombrar funciones
            (<code>calcular_total</code>, <code>mostrar_reporte</code>), mantén una sola
            responsabilidad por función y evita imprimir dentro de ella: es mejor devolver el valor.
        </div>
    </section>

    <section class="bloque">
        <h2>Estructuras de datos</h2>
        <pre><code># Lista: ordenada y modificable
frutas = ["manzana", "pera"]
frutas.append("uva")

# Diccionario: pares clave-valor
estudiante = {"nombre": "Ana", "nota": 4.6}
print(estudiante["nombre"])

# Recorrer una lista
for fruta in frutas:
    print(fruta)

# Recorrer un diccionario
for clave, valor in estudiante.items():
    print(clave, valor)</code></pre>

        <div class="demo-panel">
            <h3>Salida esperada</h3>
            <pre><code>Ana
manzana
pera
uva
nombre Ana
nota 4.6</code></pre>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
