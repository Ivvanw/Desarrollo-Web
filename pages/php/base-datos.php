<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Bases de datos en PHP';
$descripcion = 'Conexión a MySQL con PDO, consultas preparadas y CRUD básico.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';

/**
 * Completa estos datos con los de tu servidor MySQL para probar la conexión real.
 * La página funciona sin base de datos: muestra resultados simulados.
 */
$configuracion = [
    'host'     => 'localhost',
    'puerto'   => '3306',
    'base'     => 'tutor_web',
    'usuario'  => 'root',
    'clave'    => '',
];

$conexion = null;
$mensajeConexion = 'No se intentó conectar. Esta página usa datos de ejemplo.';

try {
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $configuracion['host'],
        $configuracion['puerto'],
        $configuracion['base']
    );

    $conexion = new PDO($dsn, $configuracion['usuario'], $configuracion['clave'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    $mensajeConexion = 'Conexión establecida con ' . $configuracion['base'] . '.';
} catch (PDOException $excepcion) {
    $conexion = null;
    $mensajeConexion = 'Sin conexión real: ' . $excepcion->getMessage();
}

// Datos de ejemplo: lo mismo que devolvería una consulta SELECT
$estudiantes = [
    ['id' => 1, 'nombre' => 'Ana María', 'correo' => 'ana@ejemplo.com', 'nota' => 4.6],
    ['id' => 2, 'nombre' => 'Carlos Pérez', 'correo' => 'carlos@ejemplo.com', 'nota' => 3.4],
    ['id' => 3, 'nombre' => 'Melany Gómez', 'correo' => 'melany@ejemplo.com', 'nota' => 5.0],
    ['id' => 4, 'nombre' => 'Sebastián Ruiz', 'correo' => 'sebastian@ejemplo.com', 'nota' => 2.9],
];
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Manual de PHP · 07</span>
        <h1>Bases de datos: guardar de verdad</h1>
        <p>
            Una aplicación completa necesita persistencia. PHP se conecta a MySQL mediante
            <strong>PDO</strong>, ejecuta consultas preparadas y convierte las filas en vectores
            asociativos listos para mostrar.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/python/index.php') ?>">Continuar con Python</a>
            <a class="boton boton-secundario" href="<?= url('pages/php/sesiones.php') ?>">Volver a sesiones</a>
        </div>
    </header>

    <section class="bloque">
        <h2>1. ¿Qué es una base de datos relacional?</h2>
        <p>
            Organiza la información en <strong>tablas</strong> formadas por filas y columnas.
            Cada tabla tiene una clave primaria que identifica sus registros y puede relacionarse
            con otras tablas mediante claves foráneas.
        </p>

        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🗄️</span>
                <h3>Tabla</h3>
                <p>Conjunto de datos del mismo tipo: estudiantes, productos, facturas.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🔑</span>
                <h3>Clave primaria</h3>
                <p>Identifica cada fila de forma única. Normalmente es un <code>id</code> autoincremental.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🔗</span>
                <h3>Clave foránea</h3>
                <p>Conecta una fila con otra tabla y mantiene la integridad de los datos.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">🧱</span>
                <h3>SQL</h3>
                <p>Lenguaje para crear tablas y consultar, insertar, actualizar o borrar datos.</p>
            </article>
        </div>
    </section>

    <section class="bloque">
        <h2>2. Crear la tabla</h2>
        <pre><code>CREATE DATABASE tutor_web CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE tutor_web;

CREATE TABLE estudiantes (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    nombre  VARCHAR(100) NOT NULL,
    correo  VARCHAR(120) NOT NULL UNIQUE,
    nota    DECIMAL(3,1) NOT NULL DEFAULT 0.0,
    creado  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);</code></pre>
    </section>

    <section class="bloque">
        <h2>3. Conectar con PDO</h2>
        <p>
            PDO funciona con MySQL, PostgreSQL, SQLite y otros motores. Si algún día cambias de
            base de datos, casi todo el código se mantiene.
        </p>

        <pre><code>&lt;?php
$dsn = "mysql:host=localhost;dbname=tutor_web;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, "root", "", [
        PDO::ATTR_ERRMODE            =&gt; PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE =&gt; PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   =&gt; false,
    ]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e-&gt;getMessage());
}
?&gt;</code></pre>

        <div class="alerta <?= $conexion ? 'alerta-exito' : 'alerta-info' ?>">
            <strong>Estado de la conexión:</strong>
            <span><?= e($mensajeConexion) ?></span>
        </div>
    </section>

    <section class="bloque">
        <h2>4. Las cuatro operaciones (CRUD)</h2>

        <div class="accordion" id="crudBd">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#crudCrear" aria-expanded="true" aria-controls="crudCrear">
                        Create · insertar
                    </button>
                </h2>
                <div id="crudCrear" class="accordion-collapse collapse show" data-bs-parent="#crudBd">
                    <div class="accordion-body">
                        <pre><code>&lt;?php
$sql = "INSERT INTO estudiantes (nombre, correo, nota)
        VALUES (:nombre, :correo, :nota)";

$consulta = $pdo-&gt;prepare($sql);
$consulta-&gt;execute([
    ":nombre" =&gt; "Ana María",
    ":correo" =&gt; "ana@ejemplo.com",
    ":nota"   =&gt; 4.6,
]);
?&gt;</code></pre>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#crudLeer" aria-expanded="false" aria-controls="crudLeer">
                        Read · consultar
                    </button>
                </h2>
                <div id="crudLeer" class="accordion-collapse collapse" data-bs-parent="#crudBd">
                    <div class="accordion-body">
                        <pre><code>&lt;?php
$consulta = $pdo-&gt;query("SELECT id, nombre, correo, nota
                        FROM estudiantes
                        ORDER BY nota DESC");

$estudiantes = $consulta-&gt;fetchAll();

foreach ($estudiantes as $estudiante) {
    echo $estudiante["nombre"] . " - " . $estudiante["nota"];
}
?&gt;</code></pre>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#crudActualizar" aria-expanded="false" aria-controls="crudActualizar">
                        Update · actualizar
                    </button>
                </h2>
                <div id="crudActualizar" class="accordion-collapse collapse" data-bs-parent="#crudBd">
                    <div class="accordion-body">
                        <pre><code>&lt;?php
$sql = "UPDATE estudiantes SET nota = :nota WHERE id = :id";

$consulta = $pdo-&gt;prepare($sql);
$consulta-&gt;execute([
    ":nota" =&gt; 4.8,
    ":id"   =&gt; 1,
]);
?&gt;</code></pre>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#crudBorrar" aria-expanded="false" aria-controls="crudBorrar">
                        Delete · borrar
                    </button>
                </h2>
                <div id="crudBorrar" class="accordion-collapse collapse" data-bs-parent="#crudBd">
                    <div class="accordion-body">
                        <pre><code>&lt;?php
$consulta = $pdo-&gt;prepare("DELETE FROM estudiantes WHERE id = :id");
$consulta-&gt;execute([":id" =&gt; 1]);
?&gt;</code></pre>
                        <div class="warning-box">
                            <strong>Cuidado:</strong> un <code>DELETE</code> sin <code>WHERE</code> borra toda la tabla.
                            Verifica dos veces antes de ejecutarlo.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bloque">
        <h2>5. Consulta preparada: la defensa contra la inyección SQL</h2>
        <p>
            Nunca pegues datos del usuario directamente en una consulta. Un atacante podría escribir
            <code>' OR '1'='1</code> y alterar la lógica. Las consultas preparadas envían los valores
            por separado, así que se tratan siempre como datos.
        </p>

        <div class="grid-cards">
            <article class="tarjeta">
                <h3>❌ Inseguro</h3>
                <pre><code>$sql = "SELECT * FROM estudiantes
        WHERE correo = '" . $_POST["correo"] . "'";</code></pre>
            </article>
            <article class="tarjeta">
                <h3>✅ Seguro</h3>
                <pre><code>$sql = "SELECT * FROM estudiantes
        WHERE correo = :correo";

$consulta = $pdo-&gt;prepare($sql);
$consulta-&gt;execute([":correo" =&gt; $_POST["correo"]]);</code></pre>
            </article>
        </div>
    </section>

    <section class="bloque">
        <h2>6. Resultado simulado de la consulta</h2>
        <p>
            Esta tabla representa lo que devolvería <code>SELECT * FROM estudiantes ORDER BY nota DESC</code>.
            Como aún no hay una base de datos configurada en este entorno, usamos un vector de ejemplo.
        </p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Nota</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    usort($estudiantes, fn($a, $b) => $b['nota'] <=> $a['nota']);
                    foreach ($estudiantes as $estudiante):
                    ?>
                        <tr>
                            <td><?= e($estudiante['id']) ?></td>
                            <td><?= e($estudiante['nombre']) ?></td>
                            <td><code><?= e($estudiante['correo']) ?></code></td>
                            <td><strong><?= e(number_format($estudiante['nota'], 1, ',', '.')) ?></strong></td>
                            <td>
                                <?php if ($estudiante['nota'] >= 3.0): ?>
                                    <span class="badge-pill verde">Aprueba</span>
                                <?php else: ?>
                                    <span class="badge-pill naranja">Refuerzo</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="info-box">
            <strong>Para probar en local:</strong> crea la base de datos con el script de arriba,
            ajusta las credenciales en la parte superior de este archivo y recarga la página.
            Si la conexión funciona, el aviso cambiará a verde.
        </div>
    </section>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
