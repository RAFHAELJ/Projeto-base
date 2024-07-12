#!/bin/bash
set -e

# Configurar permissões do Apache
chown -R www-data:www-data /var/www/html
chmod -R 777 /var/www/html

# Instalar dependências do Laravel
if [ ! -d "vendor" ]; then
  composer install
fi

# Gerar a chave da aplicação Laravel
if [ ! -f ".env" ]; then
  cp .env.example .env
fi

php artisan config:clear
php artisan cache:clear
php artisan key:generate
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"

#npm run dev

composer dump-autoload

# Executar migrações do Laravel, se necessárias
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force
fi

# Executar o comando original do Dockerfile (apache2-foreground)
exec "$@"
