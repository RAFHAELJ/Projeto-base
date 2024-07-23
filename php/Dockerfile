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
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    libssl-dev \
    pkg-config \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql mysqli mbstring exif pcntl bcmath zip

# Instalar as extensões MongoDB e Redis
RUN pecl install mongodb redis \
    && docker-php-ext-enable mongodb redis

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

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader --prefer-dist

# Instalar Laravel UI e configurar Vue.js
RUN composer require laravel/ui \
    && php artisan ui vue --auth \
    && composer require jenssegers/mongodb predis/predis pusher/pusher-php-server:5.0 beyondcode/laravel-websockets:1.14.1 doctrine/dbal maatwebsite/excel:^3.1

# Instalar dependências do NPM e compilar assets
COPY laravel/package.json laravel/package-lock.json /var/www/html/
RUN npm install --production --legacy-peer-deps \
    && npm install laravel-echo-server \
    && npm install emoji-mart-vue \
    && npm install --save laravel-echo pusher-js --force

# Limpar cache do Docker
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Expor a porta 80 para o Apache
EXPOSE 80

# Copiar e configurar o script de entrada
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Definir o script de entrada como ponto de entrada
ENTRYPOINT ["entrypoint.sh"]

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
