# install composer dependencies

composer update


# generate a key for your application

php artisan key:generate


# run the migration files to generate the schema

php artisan migrate


#install carbon
composer require nesbot/carbon


#run project
php -S localhost:8000 -t public/
