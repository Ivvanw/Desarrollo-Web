<?php
require_once __DIR__ . '/../../config/auth.php';
requerirLogin();

$titulo = 'APIs';
$descripcion = 'Qué es una API y cómo consumir la PokéAPI desde JavaScript.';
require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main class="container">
    <header class="page-hero">
        <span class="page-kicker">Desarrollo web · 04</span>
        <h1>APIs: comunicación entre aplicaciones</h1>
        <p>
            Una <strong>API</strong> (Application Programming Interface) es un contrato que permite que dos
            sistemas intercambien datos o funciones sin conocer su implementación interna. En la web, la
            mayoría de las APIs modernas hablan HTTP y devuelven <strong>JSON</strong>.
        </p>
        <div class="page-actions">
            <a class="boton" href="<?= url('pages/web/css.php') ?>">Siguiente: CSS</a>
            <a class="boton boton-secundario" href="<?= url('pages/web/backend.php') ?>">Volver a backend</a>
        </div>
    </header>

    <section class="bloque">
        <h2>¿Qué es una API?</h2>
        <p>
            Imagina un restaurante: tú pides de la carta, la cocina prepara el plato y el mesero lo lleva.
            La API es el mesero: recibe una petición, el servidor la procesa y devuelve una respuesta.
            El cliente no necesita entrar a la cocina ni saber cómo se cocinó.
        </p>

        <div class="grid-cards">
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">📨</span>
                <h3>Petición</h3>
                <p>El cliente indica qué recurso quiere mediante una URL y un método HTTP.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">⚙️</span>
                <h3>Procesamiento</h3>
                <p>El servidor valida la petición, consulta sus datos y construye la respuesta.</p>
            </article>
            <article class="tarjeta">
                <span class="tarjeta-icono" aria-hidden="true">📦</span>
                <h3>Respuesta</h3>
                <p>Vuelve un código de estado y un cuerpo, normalmente en formato JSON.</p>
            </article>
        </div>

        <h3>Métodos HTTP más usados</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Método</th>
                        <th>Uso</th>
                        <th>Ejemplo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><code>GET</code></td><td>Consultar información.</td><td><code>GET /pokemon/pikachu</code></td></tr>
                    <tr><td><code>POST</code></td><td>Crear un recurso.</td><td><code>POST /usuarios</code></td></tr>
                    <tr><td><code>PUT</code></td><td>Reemplazar un recurso.</td><td><code>PUT /usuarios/7</code></td></tr>
                    <tr><td><code>PATCH</code></td><td>Modificar parte de un recurso.</td><td><code>PATCH /usuarios/7</code></td></tr>
                    <tr><td><code>DELETE</code></td><td>Eliminar un recurso.</td><td><code>DELETE /usuarios/7</code></td></tr>
                </tbody>
            </table>
        </div>

        <div class="info-box">
            <strong>Códigos de estado:</strong> <code>200</code> correcto, <code>201</code> creado,
            <code>400</code> petición inválida, <code>401</code> sin autenticación, <code>404</code> no encontrado
            y <code>500</code> error del servidor.
        </div>
    </section>

    <section class="bloque">
        <h2>Consumir una API con JavaScript</h2>
        <p>
            <code>fetch()</code> es la función nativa del navegador para hacer peticiones HTTP. Devuelve una
            promesa que se resuelve con la respuesta del servidor.
        </p>

        <pre><code>async function consultarPokemon(nombre) {
    const respuesta = await fetch(`https://pokeapi.co/api/v2/pokemon/${nombre}`);

    if (!respuesta.ok) {
        throw new Error('No se encontró el Pokémon');
    }

    const datos = await respuesta.json();
    console.log(datos.name, datos.types);
}</code></pre>

        <h3>Demo: PokéAPI</h3>
        <p>
            La siguiente demo consulta una API pública y gratuita. Necesita conexión a internet.
            Prueba con <code>pikachu</code>, <code>charizard</code> o un número como <code>25</code>.
        </p>

        <section class="search-panel" aria-labelledby="buscarPokemon">
            <h2 id="buscarPokemon">Buscar un Pokémon</h2>
            <label for="pokemonInput">Nombre o número</label>
            <div class="search-row">
                <input type="text" id="pokemonInput" placeholder="Ejemplo: pikachu o 25" autocomplete="off">
                <button id="searchButton" type="button">Consultar</button>
                <button id="randomButton" class="boton boton-secundario" type="button">Aleatorio</button>
            </div>
        </section>

        <section id="result" class="result-area" aria-live="polite">
            <p class="muted-message">Escribe un nombre o número y presiona «Consultar».</p>
        </section>

        <section class="api-info" aria-labelledby="apiInfoTitle">
            <h2 id="apiInfoTitle">¿Cómo funciona esta consulta?</h2>
            <p>
                JavaScript envía una petición <code>GET</code> a la PokéAPI, recibe un JSON con la
                información del Pokémon y construye el HTML de la tarjeta sin recargar la página.
            </p>
            <code>https://pokeapi.co/api/v2/pokemon/pikachu</code>
        </section>
    </section>

    <section class="bloque">
        <h2>Buenas prácticas al consumir APIs</h2>
        <ul class="lista-caracteristicas">
            <li><strong>Valida siempre:</strong> comprueba <code>respuesta.ok</code> antes de leer el cuerpo.</li>
            <li><strong>Maneja errores:</strong> muestra un mensaje claro si la red o el servidor fallan.</li>
            <li><strong>No expongas secretos:</strong> las claves privadas van en el backend, nunca en JavaScript.</li>
            <li><strong>Respeta los límites:</strong> revisa cuotas y evita peticiones repetidas innecesarias.</li>
            <li><strong>Cachea cuando sea posible:</strong> reduce llamadas y mejora el rendimiento.</li>
        </ul>

        <div class="success-box">
            <strong>Regla de oro:</strong> una API bien documentada y un manejo de errores cuidadoso valen más
            que mil peticiones sin control.
        </div>
    </section>
</main>

<script>
    const pokemonInput = document.getElementById('pokemonInput');
    const searchButton = document.getElementById('searchButton');
    const randomButton = document.getElementById('randomButton');
    const result = document.getElementById('result');
    const maxPokemon = 1025;

    function capitalize(text) {
        return text.charAt(0).toUpperCase() + text.slice(1);
    }

    function formatName(text) {
        return text.split('-').map(capitalize).join(' ');
    }

    function showMessage(message, className = 'muted-message') {
        result.innerHTML = `<p class="${className}">${message}</p>`;
    }

    function renderPokemon(pokemon) {
        const image = pokemon.sprites.other['official-artwork'].front_default || pokemon.sprites.front_default;
        const types = pokemon.types.map(item => capitalize(item.type.name)).join(', ');
        const abilities = pokemon.abilities.map(item => formatName(item.ability.name)).join(', ');
        const stats = pokemon.stats.map(item => `
            <div class="stat-row">
                <span>${formatName(item.stat.name)}</span>
                <strong>${item.base_stat}</strong>
            </div>
        `).join('');

        result.innerHTML = `
            <article class="pokemon-card">
                <div class="pokemon-image-box">
                    <img src="${image}" alt="${formatName(pokemon.name)}">
                </div>
                <div class="pokemon-content">
                    <p class="pokemon-number">#${String(pokemon.id).padStart(4, '0')}</p>
                    <h2>${formatName(pokemon.name)}</h2>
                    <p><strong>Tipos:</strong> ${types}</p>
                    <p><strong>Habilidades:</strong> ${abilities}</p>
                    <h3>Estadísticas base</h3>
                    <div class="stats-list">${stats}</div>
                </div>
            </article>
        `;
    }

    async function searchPokemon(value) {
        const query = value.trim().toLowerCase();

        if (!query) {
            showMessage('Escribe el nombre o número de un Pokémon.', 'error-message');
            return;
        }

        showMessage('Consultando la API...', 'loading-message');

        try {
            const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${encodeURIComponent(query)}`);

            if (!response.ok) {
                throw new Error('No se encontró ese Pokémon.');
            }

            renderPokemon(await response.json());
        } catch (error) {
            showMessage(error.message, 'error-message');
        }
    }

    searchButton.addEventListener('click', () => searchPokemon(pokemonInput.value));
    randomButton.addEventListener('click', () => {
        const randomId = Math.floor(Math.random() * maxPokemon) + 1;
        pokemonInput.value = randomId;
        searchPokemon(String(randomId));
    });
    pokemonInput.addEventListener('keydown', event => {
        if (event.key === 'Enter') {
            searchPokemon(pokemonInput.value);
        }
    });
</script>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
