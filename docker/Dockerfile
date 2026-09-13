FROM php:8.2-apache

# Extensiones que usa el proyecto (mysqli)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# El proyecto se conecta con host "localhost", lo que en mysqli fuerza socket Unix.
# Apuntamos ese socket al que comparte el contenedor de MySQL.
RUN { \
      echo "mysqli.default_socket=/var/run/mysqld/mysqld.sock"; \
      echo "pdo_mysql.default_socket=/var/run/mysqld/mysqld.sock"; \
      echo "upload_max_filesize=20M"; \
      echo "post_max_size=20M"; \
    } > /usr/local/etc/php/conf.d/zz-cursox.ini

WORKDIR /var/www/html
