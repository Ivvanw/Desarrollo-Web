<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'Backend';
$descripcion = 'Qué es el backend, lenguajes de servidor, bases de datos y APIs.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Desarrollo web · 03</span>
        <h1>Backend: la lógica que el usuario no ve</h1>
        <p>
            El backend recibe peticiones, valida datos, aplica reglas de negocio, consulta la base
            de datos y devuelve una respuesta. Es el motor detrás de cada pantalla.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/web/api.php') ?>">Siguiente: APIs</a>
            <a class="boton boton-secundario" href="<?= url('pages/web/frontend.php') ?>">Volver a frontend</a>
        </div>
    </header>

    <section class="bloque">
        <h2>¿Qué es el Backend?</h2>
        <p>
            Es la parte de la aplicación que el usuario no ve directamente. En el servidor se ejecutan
            la lógica de negocio, el acceso a bases de datos, la autenticación, el procesamiento de
            datos y la seguridad. Su objetivo es recibir peticiones del frontend, procesarlas y
            devolver respuestas.
        </p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Época</th>
                        <th>Hito</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1960-1970</td><td>El procesamiento se realizaba en mainframes.</td></tr>
                    <tr><td>1991</td><td>Aparece el primer servidor web con la Web.</td></tr>
                    <tr><td>1995-2000</td><td>Se popularizan PHP, ASP y Java Servlets.</td></tr>
                    <tr><td>2005-2010</td><td>Crecen los frameworks MVC y las APIs REST.</td></tr>
                    <tr><td>2010 en adelante</td><td>Node.js, Docker, microservicios y serverless.</td></tr>
                </tbody>
            </table>
        </div>

        <h3>Características principales</h3>
        <ul class="lista-caracteristicas">
            <li><strong>Seguridad:</strong> autenticación, permisos y cifrado.</li>
            <li><strong>Escalabilidad:</strong> atención de muchos usuarios a la vez.</li>
            <li><strong>Persistencia:</strong> almacenamiento y recuperación de datos.</li>
            <li><strong>Lógica de negocio:</strong> reglas y validaciones.</li>
            <li><strong>Integración:</strong> conexión con otras APIs y servicios.</li>
        </ul>

        <div class="info-box">
            <strong>Dato clave:</strong> el frontend pide y el backend responde. Juntos forman el
            modelo cliente-servidor.
        </div>
    </section>

    <section class="bloque">
        <h2>Lenguajes de servidor</h2>
        <div class="technology-grid">
            <article class="technology-card">
                <h3>Node.js</h3>
                <p>Ejecuta JavaScript en el servidor. Es asíncrono y útil para tiempo real.</p>
                <span>Express · NestJS · Fastify</span>
            </article>
            <article class="technology-card">
                <h3>Python</h3>
                <p>Lenguaje versátil usado en web, ciencia de datos e inteligencia artificial.</p>
                <span>Django · Flask · FastAPI</span>
            </article>
            <article class="technology-card">
                <h3>PHP</h3>
                <p>Lenguaje clásico del backend presente en WordPress y Wikipedia.</p>
                <span>Laravel · Symfony</span>
            </article>
            <article class="technology-card">
                <h3>Java</h3>
                <p>Robusto y multiplataforma, muy usado en banca y empresas grandes.</p>
                <span>Spring Boot · Quarkus</span>
            </article>
            <article class="technology-card">
                <h3>C#</h3>
                <p>Parte del ecosistema .NET, usado en aplicaciones empresariales.</p>
                <span>ASP.NET Core · Blazor</span>
            </article>
            <article class="technology-card">
                <h3>Go</h3>
                <p>Rápido y eficiente, creado por Google y ideal para microservicios.</p>
                <span>Gin · Echo · Fiber</span>
            </article>
        </div>
    </section>

    <section class="bloque">
        <h2>Bases de datos</h2>
        <ul class="lista-caracteristicas">
            <li><strong>MySQL / MariaDB:</strong> bases de datos relacionales.</li>
            <li><strong>PostgreSQL:</strong> relacional avanzada y robusta.</li>
            <li><strong>MongoDB:</strong> NoSQL que almacena documentos JSON.</li>
            <li><strong>Redis:</strong> base en memoria para caché.</li>
            <li><strong>SQL Server y Oracle:</strong> soluciones empresariales.</li>
        </ul>

        <div class="success-box">
            <strong>Regla de oro:</strong> aprende SQL y una base de datos relacional antes de pasar a NoSQL.
        </div>
    </section>

    <section class="bloque">
        <h2>Código de ejemplo: servidor con Node.js y Express</h2>
        <p>Este servidor recibe peticiones y responde con datos en formato JSON:</p>

        <pre><code>const express = require('express');
const app = express();
const PORT = 3000;

app.use(express.json());

app.get('/api/usuarios', (req, res) =&gt; {
    const usuarios = [
        { id: 1, nombre: 'Maria', rol: 'Frontend' },
        { id: 2, nombre: 'Sebastian', rol: 'Backend' },
        { id: 3, nombre: 'Pancho', rol: 'Full Stack' }
    ];

    res.json(usuarios);
});

app.listen(PORT, () =&gt; {
    console.log(`Servidor en http://localhost:${PORT}`);
});</code></pre>

        <div class="demo-panel">
            <h3>Demo: simular GET /api/usuarios</h3>
            <p>Presiona el botón para ver la respuesta que devolvería el servidor.</p>
            <div class="calc-acciones">
                <button id="consultarUsuarios" type="button">Consultar usuarios</button>
                <button id="limpiarUsuarios" type="button" class="boton boton-secundario">Limpiar</button>
            </div>
            <div id="demoBackend" class="demo-result">
                <em>Presiona el botón para consultar usuarios.</em>
            </div>
        </div>

        <h3>¿Qué hace este código?</h3>
        <ul class="lista-caracteristicas">
            <li><strong>Express:</strong> simplifica la creación de servidores web.</li>
            <li><strong>app.get():</strong> define una ruta para peticiones GET.</li>
            <li><strong>res.json():</strong> envía datos en formato JSON.</li>
            <li><strong>app.listen():</strong> inicia el servidor en un puerto.</li>
        </ul>

        <div class="info-box">
            <strong>Conexión frontend + backend:</strong> desde HTML puedes consumir esta ruta con
            <code>fetch('http://localhost:3000/api/usuarios')</code>.
        </div>
    </section>
</main>

<script>
    const demoBackend = document.getElementById('demoBackend');
    const usuariosDemo = [
        { id: 1, nombre: 'Yensy', rol: 'Frontend' },
        { id: 2, nombre: 'Melany', rol: 'Backend' },
        { id: 3, nombre: 'Carlos', rol: 'Full Stack' }
    ];

    document.getElementById('consultarUsuarios').addEventListener('click', () => {
        demoBackend.innerHTML = '<p class="loading-message">Enviando petición GET /api/usuarios...</p>';

        setTimeout(() => {
            const filas = usuariosDemo
                .map(usuario => `<li><strong>ID ${usuario.id}:</strong> ${usuario.nombre} <em>(${usuario.rol})</em></li>`)
                .join('');

            demoBackend.innerHTML = `
                <p class="success-text"><strong>Respuesta del servidor: 200 OK</strong></p>
                <ul class="user-list">${filas}</ul>
                <p class="small-note">Formato JSON recibido desde el backend.</p>
            `;
        }, 500);
    });

    document.getElementById('limpiarUsuarios').addEventListener('click', () => {
        demoBackend.innerHTML = '<em>Presiona el botón para consultar usuarios.</em>';
    });
</script>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
