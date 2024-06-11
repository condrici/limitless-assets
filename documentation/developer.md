# Developer Notes

## Best Practices

### [Laravel]

#### [Info] When creating a new service provider

1. Check the classes used in the service provider (copy/paste the namespaces)
2. Register a new binding in config/app.php (follow the existing examples in the file)
3. Run php artisan optimize

#### [Issue] Newly added entry in the .env file is not seen by env()

In order for env() to be able to see the newly added env entry, run command:\
php artisan config:clear

Best solution:\
Whenever adding a new env variable in the .env file, make sure to use that value in the configuration files
stored under laravel/config/

Possible Explanation:\
If you are using the config:cache command during deployment, you must make sure that 
you are only calling the env function from within your configuration files, 
and not from anywhere else in your application.

### [Docker]

#### [Info] Important Files

Nginx container: files & commands
- /etc/nginx/nginx.conf (main configuration file)
- /etc/nginx/conf.d/ (folder with custom configs loaded by nginx.conf)
- nginx -t (show and validate the main configuration file path)

PHP container: files & commands
- /usr/local/etc/php (php .ini configuration files)
- php -i (php environment variables)

#### [Issue] 'Access-control-allow-origin' header contains multiple values '*, *', but only one is allowed.

When sending an HTTP request from the GUI Container - client side, so via the browser - to the API Nginx Container
this error can be generated (in the browser, see console log). This can happen if the nginx.conf is not properly
configured, or it doesn't have Access-control-allow-origin defined. 

For some reason setting << fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name; >> in the nginx config file
will somehow set "Access-Control-Allow-Origin: *"  in the background (not entirely sure how that works) which means that
we can no longer add << add_header Access-Control-Allow-Origin * >> in the config file, because now, add_header will
add an additional Access-Control-Allow-Origin setting, thus creating a duplicate

#### [Issue] Container exits when using an entrypoint in docker-compose.yaml

If any of the containers defined in the docker-compose.yaml file uses an entrypoint script,
you need to make sure that the script itself runs indefinitely, otherwise the container will exit
as soon as the script ends, specifically, you can either use a hacky command like 'tail -f /dev/null'
(might not always work), or start a service that the container uses

#### [INFO] Some debugging options inside docker containers

Container php-fpm:
- ps aux | grep php-fpm (ensure service php-fpm is running)\
- netstat -an | grep :9000 (check port: if running over IP, as opposed to over Unix socket)\
- nmap localhost -p 9000 (check port: with nmap)\
- service —status-all (check the status of all services)