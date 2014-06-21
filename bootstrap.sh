#!/bin/bash

apt-get update

# Install "add-apt-repository" binaries
apt-get install -y python-software-properties
# Install PHP 5.x
# Use "ppa:ondrej/php5-oldstable" for old and stable release
add-apt-repository ppa:ondrej/php5
# Update repositories
apt-get update

# PHP tools
apt-get install -y php5-cli php5-mysql php5-curl php5-mcrypt php5-gd php-pear php5-xdebug php5-intl

PHP_TIMEZONE='UTC'
# Setting the timezone
# sed 's#;date.timezone\([[:space:]]*\)=\([[:space:]]*\)*#date.timezone\1=\2\"'"$PHP_TIMEZONE"'\"#g' /etc/php5/apache2/php.ini > /etc/php5/apache2/php.ini.tmp
# mv /etc/php5/apache2/php.ini.tmp /etc/php5/apache2/php.ini
sed 's#;date.timezone\([[:space:]]*\)=\([[:space:]]*\)*#date.timezone\1=\2\"'"$PHP_TIMEZONE"'\"#g' /etc/php5/cli/php.ini > /etc/php5/cli/php.ini.tmp
mv /etc/php5/cli/php.ini.tmp /etc/php5/cli/php.ini

# Essential packages
# ------------------
apt-get install -y build-essential git-core vim curl

# Install composer
# ------------------
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Crete symfony project
# ------------------
# composer create-project symfony/framework-standard-edition myproject/ ~2.4