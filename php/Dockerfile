FROM php:8.2-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    libssl-dev \
    pkg-config

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql mysqli mbstring exif pcntl bcmath gd

# Instalar a extensão MongoDB
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Instalar a extensão Redis
RUN pecl install redis \
    && docker-php-ext-enable redis

# Copiar código-fonte para o diretório de trabalho
COPY ./laravel /var/www/html

# Configurar o Apache
RUN a2enmod rewrite

# Adicionar o arquivo de configuração personalizado
COPY ./custom.conf /etc/apache2/sites-available/custom.conf
RUN a2ensite custom.conf && a2dissite 000-default.conf

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Instalar dependências do Laravel, incluindo jenssegers/laravel-mongodb
RUN composer require jenssegers/mongodb

# Instalar Laravel UI e configurar Vue.js
RUN composer -vvv require laravel/ui \
    && php artisan ui vue --auth

# Instalar dependências do NPM e compilar assets com --legacy-peer-deps
#RUN npm install --force && npm run dev

# Expor a porta 80 para o Apache
EXPOSE 80

# Copiar e configurar o script de entrada
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Definir o script de entrada
ENTRYPOINT ["entrypoint.sh"]

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
