# Usar uma imagem oficial do PHP com o Apache
FROM php:8.0-apache

# Instalar dependências e extensões necessárias
RUN apt-get update
RUN apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    wget \
    gnupg \
    lsb-release \
    ca-certificates

# Adicionar repositório MySQL
RUN echo "deb http://repo.mysql.com/apt/debian/ $(lsb_release -cs) mysql-apt-config" > /etc/apt/sources.list.d/mysql.list

# Baixar e adicionar a chave pública do MySQL corretamente
RUN wget -q -O - https://repo.mysql.com/RPM-GPG-KEY-mysql | apt-key add -

# Atualizar a lista de pacotes
RUN apt-get update

# Instalar pacotes do MySQL
RUN apt-get install -y libmysqlclient-dev

# Instalar a extensão GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Instalar a extensão PDO e PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite

# Expor a porta 8080 no container
EXPOSE 8080

# Alterar a configuração do Apache para escutar na porta 8080
RUN echo "Listen 8080" >> /etc/apache2/ports.conf
RUN sed -i 's/80/8080/' /etc/apache2/sites-available/000-default.conf

# Alterar o DocumentRoot para o diretório public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos da aplicação para o container
COPY . .

# Instalar dependências do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Iniciar o Apache no container
CMD ["apache2-foreground"]
