FROM php:8.2-fpm

########################
# TODO: Investigate why "apt-get update" fails
# exit 0 was added so that the build doesn't exit unexpectedly
########################

RUN apt-get update; exit 0

########################
# curl, required to install composer
# unzip, required for <composer install>
########################

RUN apt-get install curl unzip -y
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm composer-setup.php