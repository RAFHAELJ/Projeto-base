#!/bin/bash
set -e

echo "Entrypoint script esta executando" >> /var/log/entrypoint.log

# Configurar permissões do Apache
echo "Configurando permissões do Apache..." 
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/ /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar dependências do Laravel se a pasta vendor não existir
if [ ! -d "/var/www/html/vendor" ]; then
    echo "Instalando dependências do Composer..."
    composer clear-cache
    composer install --no-dev --optimize-autoloader --prefer-dist
fi

# Gerar a chave da aplicação Laravel se .env não existir
if [ ! -f ".env" ]; then
    echo "Copiando .env.example para .env..."
    cp .env.example .env
fi

# Limpar e gerar caches
echo "Limpando e gerando caches..."
php artisan config:clear
php artisan cache:clear
php artisan key:generate

# Publicar e rodar migrações
echo "Publicando migrações e rodando migrations..."
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"
php artisan migrate
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"

# Gerar autoload do Composer
echo "Gerando autoload do Composer..."
composer dump-autoload

# Executar migrações do Laravel, se necessário
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Executando migrações do banco de dados..."
    php artisan migrate --force
fi
echo "Entrypoint script esta finalizado " >> /var/log/entrypoint.log
# Executar o comando original do Dockerfile (apache2-foreground)

# Execute start-services.sh
apache2-foreground &

sleep 10
# Iniciar o trabalho de fila
php artisan queue:work redis &

# Iniciar o WebSocket
php artisan websockets:serve

php artisan route:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache

exec "$@"
