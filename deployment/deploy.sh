#!/bin/bash

# Update the system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install apache2 php libapache2-mod-php php-mysql unzip -y
sudo apt install nodejs npm -y
sudo npm install pm2@latest -g

# Set up application
APP_DIR="/var/www/html/rental_management"
sudo mkdir -p $APP_DIR
sudo cp -r ../* $APP_DIR
sudo chown -R www-data:www-data $APP_DIR

# Configure MySQL
mysql -u root -p <<EOF
CREATE DATABASE IF NOT EXISTS rental_management;
USE rental_management;
$(cat ../sql/database.sql)
EOF

# Restart Apache
sudo systemctl restart apache2

# Start PM2
cd $APP_DIR
pm2 start ../deployment/php-server.json
pm2 save
pm2 startup
