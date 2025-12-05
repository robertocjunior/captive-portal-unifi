FROM php:8.2-apache
# Instala extensão para conectar no MariaDB e ativa mod_rewrite
RUN docker-php-ext-install mysqli pdo pdo_mysql && a2enmod rewrite
# Copia os arquivos
COPY src/ /var/www/html/
# Permissões
RUN chown -R www-data:www-data /var/www/html