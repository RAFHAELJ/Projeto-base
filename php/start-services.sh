#!/bin/bash

# Iniciar o Apache
apache2-foreground &

# Iniciar o trabalho de fila
php artisan queue:work redis &

# Iniciar o WebSocket
php artisan websockets:serve

php artisan cache:clear
php artisan config:cache
php artisan route:cache