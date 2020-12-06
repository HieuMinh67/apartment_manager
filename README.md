# apartment_manager
This is a student project. Own project uses Symfony framework to build this project

## System requirements
* PHP >= 7.2
* MySQL >= 5.0
* Composer
* Symfony CLI

## Run applications
composer install\
php bin/console d:database:create\
php bin/console d:s:u -f\
php bin/console doctrine:fixtures:load\
php bin/console assets/install
symfony server:start
