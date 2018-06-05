#!/bin/bash

echo Running migrations...;
yes | php yii migrate

echo Clearing cache...;
php yii clear/cache

php-fpm