FROM php:8.2-apache

# Copiar archivos al contenedor
COPY public/ /var/www/html/
COPY api/ /var/www/html/api/

# Permisos para que Apache pueda escribir JSON
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 777 /var/www/html

# Habilitar mod_rewrite y headers
RUN a2enmod rewrite headers

