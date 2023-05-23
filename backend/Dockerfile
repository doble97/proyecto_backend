# Imagen base
FROM docker.io/bitnami/laravel:10

# Variables de entorno
ENV DB_HOST=mariadb
ENV DB_PORT=3306
ENV DB_USERNAME=bn_myapp
ENV DB_DATABASE=bitnami_myapp

# Copiamos los archivos de nuestra aplicación
COPY . /app

# Establecemos el directorio de trabajo
WORKDIR /app

# Exponemos el puerto 8000
EXPOSE 8000
