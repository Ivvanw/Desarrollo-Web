#!/bin/sh
# La carpeta datos/ guarda los CSV, gráficas y PDF de cada sesión:
# el usuario de Apache (www-data) necesita poder escribir en ella.
mkdir -p /var/www/html/datos
chmod 0777 /var/www/html/datos

# Los archivos que crea Apache quedan editables también desde el equipo anfitrión
# (la carpeta del proyecto está montada en vivo): así puedes borrarlos sin sudo.
umask 0000

exec docker-php-entrypoint "$@"
