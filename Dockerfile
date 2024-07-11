FROM suyar/php:8.3-alpine-integration

COPY ./composer.json /app/
COPY ./composer.lock /app/
RUN composer install --no-interaction --no-dev --no-autoloader --no-scripts

COPY . /app

WORKDIR /app

RUN composer install --no-interaction --no-dev && composer dump-autoload

EXPOSE 8787

CMD ["php","start.php","start"]