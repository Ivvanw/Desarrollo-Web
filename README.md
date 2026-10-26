# Tutor Web · Desarrollo de Aplicaciones I

Sitio académico que reúne el material del curso **Desarrollo de Aplicaciones I** en un único
tutor interactivo. Incluye teoría de desarrollo web, manuales de PHP y Python, demos,
ejercicios de HTML/CSS y un laboratorio de análisis de datos climáticos.

Todo el contenido está protegido por una sesión: si el usuario o la contraseña están vacíos,
no es posible abrir ninguna página del tutor.

---

## Características

- Diseño oscuro responsive construido con Bootstrap 5.3 y CSS propio.
- Login con sesión, token CSRF y contraseña almacenada como hash SHA-256.
- Protección global: cada página y cada endpoint llama a `requerirLogin()` o verifica la sesión.
- Estructura organizada por módulos y carpetas.
- Manual de PHP con ejemplos ejecutables.
- Manual de Python con gráficas, galería Matplotlib y análisis de un CSV real.
- Descarga de clima desde Open-Meteo y exportación de reportes a PDF.
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

## Puesta en marcha

1. Copia la carpeta `Desarrollo-Web` dentro del directorio público de Apache
   (`htdocs`, `www` o similar).
2. Verifica que Apache tenga activo `AllowOverride All` para que se apliquen los `.htaccess`.
3. Da permisos de escritura a la carpeta `datos/` para el usuario del servidor web:

   ```bash
   chmod -R 775 datos
   ```

4. Abre el sitio en el navegador:

   ```text
   http://localhost/Desarrollo-Web/
   ```

5. Inicia sesión con `admin` / `123`.

La URL base se calcula automáticamente, por lo que el sitio funciona tanto en la raíz del
servidor como dentro de una subcarpeta.

---

## Estructura del proyecto

```text
Desarrollo-Web/
├── index.php                 # Login (única página pública)
├── inicio.php                # Panel principal autenticado
├── logout.php                # Cierre de sesión
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
│   ├── header.php            # Carrusel y menú principal
│   ├── footer.php            # Pie de página y scripts
│   └── .htaccess             # Acceso denegado
├── assets/
│   ├── css/estilos.css       # Sistema de diseño oscuro
│   ├── js/app.js             # Interacciones generales
│   └── img/                  # Carousel, diagramas, banners, Matplotlib, etc.
├── pages/
│   ├── ia.php                # Módulo de inteligencia artificial
│   ├── web/                  # Conceptos, frontend, backend, APIs, CSS, presentación
│   ├── php/                  # Manual de PHP
│   ├── python/               # Manual de Python y análisis climático
│   └── material/
│       ├── index.php         # Índice de material
│       └── html-basico/      # Ejercicios de HTML + imágenes originales
├── api/
│   ├── clima.php             # CSV del clima (requiere sesión)
│   └── imagen.php            # Gráficas PNG por sesión (requiere sesión)
├── python/
│   ├── analisis_clima.py     # Análisis con pandas y Matplotlib
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

- Todas las páginas del tutor llaman a `requerirLogin()` al inicio.
- `index.php` es la única página pública y redirige a `inicio.php` si ya hay sesión.
- El formulario de login usa un token CSRF y rechaza usuario o contraseña vacíos.
- La contraseña no se guarda en texto plano: se compara un hash SHA-256 con `hash_equals`.
- La sesión usa cookies `HttpOnly`, `SameSite=Lax` y `Secure` cuando hay HTTPS.
- `api/clima.php` y `api/imagen.php` verifican la sesión antes de responder.
- `api/imagen.php` valida el nombre del archivo y solo sirve PNG de la sesión actual.
- Las carpetas `config/`, `includes/`, `python/` y `datos/` bloquean el acceso HTTP directo.
- La subida de CSV se valida con CSRF, extensión, tamaño máximo (2 MB) y carpeta por sesión.

> En producción, sirve el sitio bajo HTTPS, cambia las credenciales y considera mover
> la autenticación a una base de datos con contraseñas `password_hash()`.

---

## Notas sobre Python

- Las gráficas y el PDF se generan en `datos/<id-de-sesión>/`.
- `api/imagen.php` sirve únicamente archivos con el patrón `graficaN_nombre.png`.
- El clima se descarga de Open-Meteo (sin clave) para los últimos 365 días.
- Si `pandas`, `matplotlib` o `fpdf` no están instalados, el sitio no falla: muestra
  contenido de ejemplo y un aviso.

---

## Créditos

**Ivan Andres Chimunja Beltran** · Tecnólogo en Desarrollo de Software  
Colegio Mayor del Cauca · Desarrollo de Aplicaciones I
