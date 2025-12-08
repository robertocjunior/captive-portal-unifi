FROM php:8.2-apache

# Atualiza pacotes e instala dependencias do cURL
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP: mysqli (banco), pdo, e CURL (UniFi)
RUN docker-php-ext-install mysqli pdo pdo_mysql curl && a2enmod rewrite

# Copia os arquivos (Backup caso o volume falhe)
COPY src/ /var/www/html/

# Permissões
RUN chown -R www-data:www-data /var/www/html