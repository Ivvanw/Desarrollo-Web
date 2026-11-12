# Tutor Web · Desarrollo de Aplicaciones I

Sitio académico que reúne el material del curso **Desarrollo de Aplicaciones I** en un único
tutor interactivo. Incluye teoría de desarrollo web, manuales de PHP y Python, demos,
ejercicios de HTML/CSS y un laboratorio de análisis de datos climáticos.

El sitio está separado en dos partes, igual que la guía de clase:

- **Tutor de PHP** (`index.php`, `pages/`): acceso libre, con su propio menú (acento índigo).
- **Manual de Python** (`manual-python/`): pide contraseña, con su propio menú (acento gris plateado).

Si escribes a mano una ruta del manual de Python sin haber iniciado sesión, el sitio te lleva a
`manual-python/login.php` y, al entrar, te devuelve a la página que pediste. Con usuario o
contraseña vacíos no es posible entrar. Arriba de cada página hay un carrusel con los banners
del autor (`assets/img/carousel1.svg`, `carousel2.svg` y `carousel3.svg`).

---

## Características

- Diseño oscuro responsive inspirado en GitHub (paleta Primer), construido con Bootstrap 5.3 y CSS propio.
- Login con sesión, token CSRF y contraseña almacenada como hash SHA-256.
- Manual de Python protegido: cada página de `manual-python/` llama a `requerirLogin()` y cada endpoint verifica la sesión.
- Estructura organizada por módulos y carpetas.
- Manual de PHP con ejemplos ejecutables.
- Manual de Python con gráficas, galería Matplotlib y análisis de un CSV real.
- Descarga de sismos reales desde el USGS (Colombia o el mundo) y exportación de reportes a PDF.
- No requiere base de datos: la página de PDO incluye datos de ejemplo.
- Protección de carpetas internas mediante `.htaccess` (Apache).

---

## Credenciales de demostración

| Usuario | Contraseña |
| ------- | ---------- |
| `admin` | `123`      |

El acceso con campos vacíos se rechaza de forma explícita. Cambia estas credenciales antes de
publicar el sitio en producción.

Para generar un nuevo hash de contraseña:

```bash
php -r "echo hash('sha256', 'NUEVA_CLAVE'), PHP_EOL;"
```

Luego reemplaza `CLAVE_HASH` en `config/auth.php` y el usuario en `USUARIO_DEMO`.

---

## Requisitos

- **PHP 8.0 o superior** con las extensiones habituales (`session`, `json`, `mbstring`).
  El sitio usa `str_starts_with`, `str_ends_with` y tipos `mixed`.
- **Apache** con `mod_rewrite`/`.htaccess` habilitado (o Nginx con reglas equivalentes).
- **Python 3** para el laboratorio de análisis (opcional).
- **pandas**, **matplotlib** y **fpdf** para ejecutar el análisis y exportar el PDF:

```bash
python3 -m pip install -r requirements.txt
```

Si faltan estas librerías, las páginas de Python muestran ejemplos estáticos en lugar de
ejecutar el análisis real.

La variable de entorno `PYTHON_BIN` permite indicar el intérprete:

```bash
export PYTHON_BIN=/usr/bin/python3
```

En Windows/XAMPP, `config/config_python.php` busca instalaciones típicas de Python si no está
en el `PATH`.

---

## Puesta en marcha con Docker (recomendado)

La imagen incluye PHP 8.3, Apache y Python con pandas, matplotlib y fpdf2, así que el
análisis climático y el PDF funcionan sin instalar nada más:

```bash
docker compose up -d --build
```

Abre `http://localhost:8099/`. El código se monta en vivo, así que los cambios se ven
sin reconstruir. Para detenerlo: `docker compose down`.

## Puesta en marcha manual (XAMPP / Apache)

1. Copia la carpeta `DesarrollowebIIA` dentro del directorio público de Apache
   (`htdocs`, `www` o similar).
2. Verifica que Apache tenga activo `AllowOverride All` para que se apliquen los `.htaccess`.
3. Da permisos de escritura a la carpeta `datos/` para el usuario del servidor web:

   ```bash
   chmod -R 775 datos
   ```

4. Abre el sitio en el navegador:

   ```text
   http://localhost/DesarrollowebIIA/
   ```

5. El tutor de PHP abre directamente; para el manual de Python inicia sesión con `admin` / `123`.

La URL base se calcula automáticamente, por lo que el sitio funciona tanto en la raíz del
servidor como dentro de una subcarpeta.

---

## Estructura del proyecto

```text
DesarrollowebIIA/
├── logout.php                # Cierre de sesión (vuelve al tutor de PHP)
├── index.php                 # Portada del tutor de PHP
├── Dockerfile                # PHP 8.3 + Apache + Python
├── docker-compose.yml        # Levanta el sitio en el puerto 8099
├── docker/entrypoint.sh      # Permisos de datos/ al arrancar
├── requirements.txt          # Dependencias de Python
├── robots.txt                # Sin indexación (sitio privado)
├── .htaccess                 # Opciones generales y cabeceras de seguridad
├── config/
│   ├── config.php            # URL base, rutas y helpers
│   ├── auth.php              # Sesión, credenciales, CSRF y requerirLogin()
│   ├── config_python.php     # Detección y ejecución de Python
│   └── .htaccess             # Acceso denegado
├── includes/
│   ├── head.php              # <head> compartido
│   ├── header.php            # Barra del tutor de PHP (estilo GitHub)
│   ├── header-python.php     # Barra del manual de Python
│   ├── footer.php            # Pie de página y scripts
│   └── .htaccess             # Acceso denegado
├── assets/
│   ├── css/estilos.css       # Sistema de diseño oscuro estilo GitHub
│   ├── js/app.js             # Interacciones generales
│   └── img/                  # Carrusel, diagramas, Matplotlib, foto, etc.
├── pages/
│   ├── ia.php                # Módulo de inteligencia artificial
│   ├── web/                  # Conceptos, frontend, backend, APIs, CSS, presentación
│   ├── php/                  # Manual de PHP
│   └── material/
│       ├── index.php         # Índice de material
│       └── html-basico/      # Ejercicios de HTML + imágenes originales
├── manual-python/            # Manual de Python (área privada)
│   ├── login.php             # Acceso al manual de Python
│   ├── index.php, variables.php, operadores.php, comandos.php
│   ├── graficas.php, matplotlib.php
│   ├── analisis-datos.php    # Laboratorio de análisis de sismos
│   ├── exportar-pdf.php
│   └── api/
│       ├── sismos.php        # CSV de sismos del USGS (requiere sesión)
│       └── imagen.php        # Gráficas PNG por sesión (requiere sesión)
├── python/
│   ├── analisis_sismos.py    # Análisis con pandas y Matplotlib
│   ├── reporte_pdf.py        # Reporte PDF con fpdf
│   ├── clase_csv_matplotlib/ # Ejemplos y CSV de la clase
│   ├── ejemplos/             # Scripts de ejemplo
│   └── .htaccess             # Acceso directo denegado
└── datos/
    ├── .htaccess             # Acceso directo denegado
    └── .gitkeep              # Carpeta para archivos temporales por sesión
```

---

## Seguridad

- El tutor de PHP es libre; todas las páginas de `manual-python/` llaman a `requerirLogin()`.
- Sin sesión, cualquier ruta del manual de Python redirige a `manual-python/login.php`; tras el login
  se vuelve solo a rutas internas del sitio (no hay redirecciones abiertas a otros dominios).
- El formulario de login usa un token CSRF y rechaza usuario o contraseña vacíos.
- La contraseña no se guarda en texto plano: se compara un hash SHA-256 con `hash_equals`.
- La sesión usa cookies `HttpOnly`, `SameSite=Lax` y `Secure` cuando hay HTTPS.
- `manual-python/api/sismos.php` e `imagen.php` verifican la sesión antes de responder.
- `manual-python/api/imagen.php` valida el nombre del archivo y solo sirve PNG de la sesión actual.
- Las carpetas `config/`, `includes/`, `python/` y `datos/` bloquean el acceso HTTP directo.
- La subida de CSV se valida con CSRF, extensión, tamaño máximo (2 MB) y carpeta por sesión.

> En producción, sirve el sitio bajo HTTPS, cambia las credenciales y considera mover
> la autenticación a una base de datos con contraseñas `password_hash()`.

---

## Notas sobre Python

- Las gráficas y el PDF se generan en `datos/<id-de-sesión>/`.
- `manual-python/api/imagen.php` sirve únicamente archivos con el patrón `graficaN_nombre.png`.
- Los sismos se descargan del catálogo del USGS (sin clave) para los últimos 365 días:
  `?region=colombia` (Colombia y alrededores, magnitud 2.5+) o `?region=mundo` (magnitud 4.5+).
- Si `pandas`, `matplotlib` o `fpdf` no están instalados, el sitio no falla: muestra
  contenido de ejemplo y un aviso.

---

## Créditos

**Ivan Andres Chimunja Beltran** · Tecnólogo en Desarrollo de Software  
Colegio Mayor del Cauca · Desarrollo de Aplicaciones I
