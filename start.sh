#!/bin/bash

# Actualizar la configuración de Apache para usar el puerto dinámico de Render ($PORT)
sed -i "s/80/${PORT:-80}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Limpiar y cachear configuración para producción
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Nota: No ejecutamos migraciones automáticamente (php artisan migrate --force) 
# para evitar riesgos destructivos y fallos si la base de datos no está disponible al iniciar.
# Se deben ejecutar manualmente desde la consola (Shell) de Render si es necesario.

# Iniciar Apache en primer plano
exec apache2-foreground
