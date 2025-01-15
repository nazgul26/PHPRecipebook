#!/bin/sh

# Update Schema if needed
/var/www/html/bin/cake migrations migrate

CONTAINER_FIRST_STARTUP="CONTAINER_FIRST_STARTUP"
if [ ! -e /var/www/html/$CONTAINER_FIRST_STARTUP ]; then
    touch /var/www/html/$CONTAINER_FIRST_STARTUP
    # Only run seed once
    /var/www/html/bin/cake migrations seed
fi

apache2ctl -DFOREGROUND