# Dockerfile para desplegar PHP + Apache en Render
FROM php:8.2-apache

# Habilitar módulos necesarios de Apache
RUN a2enmod rewrite

# Opcional: instalar extensiones comunes de PHP (agrega las que necesites)
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable mysqli pdo_mysql

# Copiamos el código al DocumentRoot
COPY . /var/www/html/

# Configuración para permitir .htaccess (si lo usas) y ajustar DocumentRoot
RUN sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf || true

# Script de arranque para ajustar Apache al puerto proporcionado por Render ($PORT)
COPY render/apache-run.sh /usr/local/bin/apache-run
RUN sed -i 's/\r$//' /usr/local/bin/apache-run && chmod +x /usr/local/bin/apache-run

# Exponer el puerto (informativo). Render asigna $PORT en runtime.
EXPOSE 80

# Comando por defecto
CMD ["/usr/local/bin/apache-run"]
