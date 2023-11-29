php artisan down
git pull origin
composer install
php artisan cache:clear
php artisan route:cache
php artisan config:cache
php artisan optimize
composer dump-autoload -o
php artisan up
service php-fpm restart
service php72-php-fpm restart