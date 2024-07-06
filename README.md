# Limitless ASSETS

Limitless ASSETS is one of the components of the Limitless Project that serves as an asset management service.

It is based on Laravel and PHP 8 and it's functions are accessed via Limitless API, which serves as an api gateway. In the README of the installation repository "Limitless", you can find a diagram that shows how all components work together.

## Getting Started

#### Project Components

- limitless (Installation Repository)
- limitless-gui (Web Graphical Interface, JavaScript/VueJS, [repository link](https://github.com/condrici/limitless-gui))
- limitless-api (Web API Gateway, PHP/Laravel, [repository link](https://github.com/condrici/limitless-api))
- limitless-assets (Asset Management, PHP/Laravel, [repository link](https://github.com/condrici/limitless-assets))
- limitless-analytics (Analytics, Python/Flask API/BeautifulSoup, [repository link](https://github.com/condrici/limitless-analytics))

#### Installation Requirements
- Docker (needed for the infrastructure)
- Lnav utility (used for aggregating log files)
- Bash utility (for various scripts)

#### Installation Steps
- From the "limitless" repostory, run command: sh commands/install

## Important Files

**commands/install** (script executed during the project installation via the "limitless" repository; among other things, it creates the ./laravel/.env file from an existing sample file)

**docker/entrypoint/php-fpm-entrypoint.sh** (commands that get executed when the docker environment starts)

**./docker-compose.yaml** (configuration for the Docker environment)

**./.env** (environment variables used within the Docker environment; this file is created from ./.env.example when commands/install is executed)

**./laravel/.env** (environment variables used in Laravel; this file is created from ./.env.example when commands/install is executed)

**./laravel/composer.json** (laravel project dependencies)

## Commands

Some of the commands below will be triggered in the php-fpm-entrypoint.sh file automatically when starting the Docker environment.

**php artisan key:generate** (sets the Laravel APP_KEY value in the ./laravel/.env file)

**php artisan cache:clear** (clear Laravel cache)

**php artisan config:cache** (generate Laravel cache)

## Developer Notes

### Laravel Documentation

See [Laravel 10.x Documentation](https://laravel.com/docs/10.x/releases).
