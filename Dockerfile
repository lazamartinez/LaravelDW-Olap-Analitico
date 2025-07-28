FROM php:8.2-fpm

# Instalar dependencias básicas + herramientas de diagnóstico
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    git \
    curl \
    procps \          
    net-tools \       
    iputils-ping \    
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Instalar Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && corepack enable

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar permisos
RUN chown -R www-data:www-data /var/www

# Puerto de PHP-FPM
EXPOSE 9000

# Configurar supervisor para gestionar procesos
RUN apt-get install -y supervisor
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Instalar supervisor
RUN apt-get update && apt-get install -y supervisor

# Copiar configuración
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Cambiar el CMD
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]