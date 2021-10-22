#!/bin/bash

if [ ! -f composer.json ]; then
    echo "Please make sure to run the script from the root directory of the project."
    exit 1
fi

echo "Installing dependencies"
composer install
cp .env.example .env
php artisan key:generate

FILENAME=".env"

read -p "Enter value for DB_DATABASE=" DB_DATABASE
read -p "Enter value for DB_USERNAME=" DB_USERNAME
read -s -p "Enter value for DB_PASSWORD=" DB_PASSWORD

sed -i "s/DB_DATABASE=laravel/DB_DATABASE=$DB_DATABASE/" $FILENAME
sed -i "s/DB_USERNAME=root/DB_USERNAME=$DB_USERNAME/" $FILENAME
sed -i "s/DB_PASSWORD=/DB_PASSWORD=$DB_PASSWORD/" $FILENAME

mysql --login-path=client -e "CREATE DATABASE ${DB_DATABASE};"

php artisan migrate:fresh
php artisan db:seed

echo "Done!"
