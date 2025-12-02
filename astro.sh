

#!/bin/bash
set -e

echo "=== Iniciando entrypoint.sh ==="

# Navegar al directorio de Laravel
cd /var/www/html/gestionEnvios



# Verificar si ya está configurado (si existe vendor/)
if [ ! -d "vendor" ]; then
    echo ">>> Ejecutando configuración inicial..."
    
    # crear el .env
    if [ ! -f ".env" ]; then
        echo "- Copiando .env.example a .env"
        cp .env.example .env
    fi
        
    # Instalar dependencias
    echo "- Instalando dependencias de Composer"
    composer update 
    
    echo "- Generando application key"
    php artisan key:generate 
    
    echo "- Ejecutando migraciones"
    php artisan migrate --force
    
    echo "- Ejecutando seeders"
    php artisan db:seed 
    
    echo "- Creando enlace simbólico de storage"
    php artisan storage:link
    
    echo "- Instalando dependencias de npm"
    npm install
    
    echo "- Compilando assets"
    npm run build
else
    echo ">>> Aplicación ya configurada, saltando setup inicial"
fi

php artisan serve --host=0.0.0.0

