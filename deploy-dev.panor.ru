#!/bin/bash

PROJECT=$3 #dev.panor.ru
PROD_PATH=/var/www/html
CURR_DIR=`pwd`

if [ -d "$PROD_PATH/$PROJECT" ]; then
    echo "Update project from [$PROD_PATH/$PROJECT] git..."
    cd $PROD_PATH/$PROJECT
    git fetch https://$1:$2@gl.panor.ru/web/laravel-panor.git
    git reset --hard origin/master
    git pull https://$1:$2@gl.panor.ru/web/laravel-panor.git
    php72 /usr/bin/composer update
    cd $CURR_DIR
else
    echo "Cloning project [$PROJECT] from git..."
    git clone https://$1:$2@gl.panor.ru/web/laravel-panor.git $PROD_PATH/$PROJECT
    cd $PROD_PATH/$PROJECT
    php72 /usr/bin/composer install
    cd $CURR_DIR
fi

sudo /usr/local/bin/rightchk $PROD_PATH/$PROJECT nginx:nginx 775 664

if [ -d "$PROD_PATH/$PROJECT/node_modules" ]; then
    rm -r $PROD_PATH/$PROJECT/node_modules
    cd $PROD_PATH/$PROJECT
    npm install
    npm run prod
    cd $CURR_DIR
fi
