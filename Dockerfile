FROM php:8.1
#WORKDIR /var/www/html 
RUN docker-php-ext-install mysqli

COPY ./ ./
EXPOSE 8000
CMD [ "php","-S","0.0.0.0:8000"]

