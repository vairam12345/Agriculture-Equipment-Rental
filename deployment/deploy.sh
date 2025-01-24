#!/bin/bash

# Update system
sudo apt update && sudo apt upgrade -y

# Install Apache, PHP, and MySQL
sudo apt install apache2 php libapache2-mod-php php-mysql unzip -y

# Install PM2
sudo apt install nodejs npm -y
sudo npm install pm2@latest -g

# Set up application
APP_DIR="/var/www/html/rental_management"
sudo mkdir -p $APP_DIR
sudo cp -r ./* $APP_DIR
sudo chown -R www-data:www-data $APP_DIR

# Configure MySQL
mysql -u root -p <<EOF
CREATE DATABASE rental_management;
USE rental_management;
$(cat ./sql/database.sql)
EOF

# Restart Apache
sudo systemctl restart apache2

# Run PM2
cd $APP_DIR
pm2 start php --name "RentalApp" -- php -S 0.0.0.0:8080
pm2 startup
pm2 save
