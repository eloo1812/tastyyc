# Usar uma imagem oficial do PHP com o Apache
FROM php:8.0-apache

# Instalar dependências e extensões necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    libmariadb-dev-compat \
    && apt-get clean

# Instalar a extensão GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Instalar a extensão do MySQL (PDO e PDO MySQL)
RUN docker-php-ext-install pdo pdo_mysql

# Instalar a extensão mbstring (se necessário)
RUN docker-php-ext-install mbstring

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite

# Permitir .htaccess e ajustar o Apache para escutar na porta 8080
RUN sed -i 's|AllowOverride None|AllowOverride All|' /etc/apache2/apache2.conf
RUN echo "Listen 8080" >> /etc/apache2/ports.conf
RUN sed -i 's/80/8080/' /etc/apache2/sites-available/000-default.conf

# Alterar o DocumentRoot para o diretório public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Expor a porta 8080 no container
EXPOSE 8080

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos da aplicação para o container
COPY . .

# Ajustar permissões de arquivos e diretórios
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar as dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# Iniciar o Apache no container
CMD ["apache2-foreground"]
