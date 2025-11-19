# Usa PHP con Apache
FROM php:8.2-apache

# Copia los archivos públicos y API
COPY public/ /var/www/html/public/
COPY api/ /var/www/html/api/

# Crear carpeta public en caso no exista y permisos
RUN mkdir -p /var/www/html/public && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 777 /var/www/html/public

# Expone el puerto 80
EXPOSE 80

