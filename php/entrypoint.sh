#!/bin/bash
set -e

# Configurar permissões do Apache
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/ /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar dependências do Laravel se a pasta vendor não existir
if [ ! -d "/var/www/html/vendor" ]; then
    echo "Instalando dependências do Composer..."
    composer clear-cache

    composer install --no-dev --optimize-autoloader --prefer-dist
fi

# Gerar a chave da aplicação Laravel
if [ ! -f ".env" ]; then
    echo "Copiando .env.example para .env..."
    cp .env.example .env
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

# Executar migrações do Laravel, se necessárias
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Executando migrações do banco de dados..."
    php artisan migrate --force
fi

# Executar o comando original do Dockerfile (apache2-foreground)
exec "$@"
