FROM php:8.2-apache

# Argumentos para UID/GID dinámicos
ARG UID=1000
ARG GID=1000

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer globalmente
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar nodejs
RUN apt-get install -y nodejs npm

# Activar mod_rewrite y configuración
RUN a2enmod rewrite

# Configurar permisos y acceso a /var/www/html
RUN printf "<Directory /var/www/html>\nOptions Indexes FollowSymLinks\nAllowOverride All\nRequire all granted\n</Directory>\n" \
    > /etc/apache2/conf-available/z-laravel.conf \
    && a2enconf z-laravel

# Crear usuario con UID/GID del host
RUN groupadd -g ${GID} laravel && \
    useradd -u ${UID} -g ${GID} -m laravel

# Configurar Apache para correr como el usuario laravel
RUN sed -i "s/export APACHE_RUN_USER=.*/export APACHE_RUN_USER=laravel/" /etc/apache2/envvars && \
    sed -i "s/export APACHE_RUN_GROUP=.*/export APACHE_RUN_GROUP=laravel/" /etc/apache2/envvars





# Dar permisos al webroot
RUN chown -R laravel:laravel /var/www/html

COPY astro.sh /usr/local/bin/astro.sh
RUN chmod +x /usr/local/bin/astro.sh

# Cambiar a usuario no root
USER laravel

WORKDIR /var/www/html





EXPOSE 8000

CMD ["/usr/local/bin/astro.sh"]