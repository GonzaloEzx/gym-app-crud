#!/bin/bash

# Script para inicializar el servidor local

# Iniciar Apache y MySQL en XAMPP
echo "Iniciando Apache y MySQL en XAMPP..."
/c/xampp/xampp_start.exe

# Verificar si Apache y MySQL están corriendo
echo "Verificando servicios de Apache y MySQL..."
APACHE_RUNNING=$(netstat -an | findstr :80)
MYSQL_RUNNING=$(netstat -an | findstr :3306)

if [[ -z "$APACHE_RUNNING" ]]; then
    echo "Error: Apache no está corriendo. Por favor, verifica la instalación de XAMPP."
    exit 1
fi

if [[ -z "$MYSQL_RUNNING" ]]; then
    echo "Error: MySQL no está corriendo. Por favor, verifica la instalación de XAMPP."
    exit 1
fi

echo "Apache y MySQL están corriendo."

# Iniciar el servidor PHP
echo "Iniciando el servidor PHP en http://localhost:8000..."
php -S localhost:8000 -t public &

# Verificar si el servidor PHP se inició correctamente
PHP_RUNNING=$(netstat -an | findstr :8000)

if [[ -z "$PHP_RUNNING" ]]; then
    echo "Error: El servidor PHP no se pudo iniciar. Por favor, verifica la configuración."
    exit 1
fi

echo "El servidor PHP está corriendo en http://localhost:8000"

# Abrir el navegador web
echo "Abriendo el navegador web..."
start http://localhost:8000

echo "Todo está listo. El servidor está corriendo."
