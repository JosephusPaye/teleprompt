#!/usr/bin/env bash

# This file runs each time the container is started
# (regardless of the command passed to `docker run`)

# Update PHP-FPM config to run as current user
if [ ! -z "$WWWUSER" ]; then
    # Find all "user = ..." and replace with "user = $WWWUSER" in the php www config file
    sed -i "s/user\ \=.*/user\ \= $WWWUSER/g" /etc/php/7.4/fpm/pool.d/www.conf

    # Set UID of user `teleprompt`
    usermod -u $WWWUSER teleprompt
fi

# Change `storage` and `bootstrap/cache` directory permissions
# to allow the current owner ($WWWUSER) to read and write to them
if [ -d /var/www/html/storage ]; then
    chmod -R ug+rw /var/www/html/storage
fi

if [ -d /var/www/html/bootstrap/cache ]; then
    chmod -R ug+rw /var/www/html/bootstrap/cache
fi

# Ensure `/.composer` exists and is writable
# This is where composer stores temporary files
if [ ! -d /.composer ]; then
    mkdir /.composer
fi

# Make the composer directory writable by the current user
chmod -R ugo+rw /.composer

# Add the composer vendor bin to the path
PATH=$PATH:/.composer/vendor/bin

# Run a command or start supervisord, which starts nginx and php-fpm
if [ $# -gt 0 ]; then
    # We passed a command, run it as the current user
    exec gosu $WWWUSER "$@"
else
    # No command passed, run supervisord
    /usr/bin/supervisord
fi
