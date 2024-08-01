#!/bin/bash
set -e

# Configurar permissões do Apache
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/ /var/www/html/storage /var/www/html/bootstrap/cache

# Criar a pasta vendor se não existir
if [ ! -d "/var/www/html/vendor" ]; then
    mkdir -p /var/www/html/vendor
    chown -R www-data:www-data /var/www/html/vendor
fi

# Instalar dependências do Laravel se a pasta vendor estiver vazia
if [ ! "$(ls -A /var/www/html/vendor)" ]; then
    echo "Instalando dependências do Composer..."
    composer install --no-dev --optimize-autoloader --prefer-dist
fi

# Copiar .env.example para .env se .env não existir
if [ ! -f "/var/www/html/.env" ]; then
    echo "Copiando .env.example para .env..."
    cp /var/www/html/.env.example /var/www/html/.env
    chown www-data:www-data /var/www/html/.env
fi

echo "Limpando e gerando caches..."
php artisan config:clear
php artisan cache:clear
php artisan key:generate
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"
php artisan migrate
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"

echo "Gerando autoload do Composer..."
composer dump-autoload

# Executar migrações do Laravel, se necessário
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Executando migrações do banco de dados..."
    php artisan migrate --force
fi

# Executar o comando original do Dockerfile (apache2-foreground)
exec "$@"
