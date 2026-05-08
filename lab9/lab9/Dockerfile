FROM php:8.5-fpm

# Устанавливаем расширения PHP
RUN docker-php-ext-install pdo pdo_mysql

# Устанавливаем системные пакеты
RUN apt-get update && apt-get install -y \
    zip unzip git \
    && rm -rf /var/lib/apt/lists/*

# Копируем Composer из официального образа
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www/html

# Копируем код приложения
COPY ./code /var/www/html

# Команда по умолчанию
CMD ["php-fpm"]