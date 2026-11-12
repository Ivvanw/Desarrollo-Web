# Tutor Web: PHP 8.3 + Apache + Python (pandas, matplotlib, fpdf2)
FROM php:8.3-apache

# Python para el laboratorio de análisis y la exportación a PDF
RUN apt-get update \
    && apt-get install -y --no-install-recommends python3 python3-venv \
    && rm -rf /var/lib/apt/lists/*

COPY requirements.txt /tmp/requirements.txt
RUN python3 -m venv /opt/venv \
    && /opt/venv/bin/pip install --no-cache-dir -r /tmp/requirements.txt

# config_python.php usa esta variable para encontrar el intérprete
ENV PYTHON_BIN=/opt/venv/bin/python \
    MPLCONFIGDIR=/tmp/matplotlib

# .htaccess activos y cabeceras de seguridad
RUN a2enmod rewrite headers \
    && sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && echo 'ServerName localhost' > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

COPY docker/entrypoint.sh /usr/local/bin/tutor-entrypoint
RUN chmod +x /usr/local/bin/tutor-entrypoint

ENTRYPOINT ["tutor-entrypoint"]
CMD ["apache2-foreground"]
