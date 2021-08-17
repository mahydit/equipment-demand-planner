# equipment-demand-planner
Simple application to show rental order details.
## Installation
```
composer install  
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
php bin/console assets:install --symlink public
php -S localhost:8000 -t public/
```
