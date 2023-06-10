# # Imagen base
# FROM docker.io/bitnami/laravel:10

# Variables de entorno
# ENV DB_HOST=mariadb
# ENV DB_PORT=3306
# ENV DB_USERNAME=bn_myapp
# ENV DB_DATABASE=bitnami_myapp

# # Copiamos los archivos de nuestra aplicación
# COPY . /app

# # Establecemos el directorio de trabajo
# WORKDIR /app

# # Exponemos el puerto 8000
# EXPOSE 80



# Utilizamos la imagen oficial de Composer como base
FROM composer:latest

# Copiamos los archivos de la aplicación Laravel al directorio de trabajo del contenedor
COPY . /var/www/html

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Instalamos las dependencias de la aplicación Laravel
RUN composer install --no-interaction --optimize-autoloader

# Exponemos el puerto 8000 para acceder a la aplicación desde el host
EXPOSE 8000

# Comando para ejecutar la aplicación Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
