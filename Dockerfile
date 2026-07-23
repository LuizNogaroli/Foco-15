FROM php:8.4-apache

# Instalar dependências do sistema e extensões do PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql gd zip

# Instalar Node.js (necessário para o Vite/Tailwind)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Habilitar o mod_rewrite do Apache (essencial para as rotas do Laravel)
RUN a2enmod rewrite

# Configurar a pasta public do Laravel como a raiz do Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar os arquivos do projeto
COPY . .

# Instalar dependências do PHP e Node.js.
# O diretório bootstrap/cache precisa existir para o package:discover funcionar
RUN mkdir -p bootstrap/cache \
    && cp .env.example .env \
    && composer install --no-dev --optimize-autoloader \
    && rm .env

RUN npm install && npm run build

# Ajustar permissões para o Laravel poder escrever logs e arquivos de cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copiar e configurar o script de inicialização
COPY start.sh /usr/local/bin/start
RUN chmod +x /usr/local/bin/start

# Expor a porta 80
EXPOSE 80

# Iniciar o script
CMD ["start"]
