#!/bin/sh

set -o errexit
set -o nounset

# Update Schema if needed
echo "Running migrations" >&2
/var/www/html/bin/cake migrations migrate

# Run seed if requested
if [ "${PHPRB_INSERT_SEEDS:-}" = "true" ]; then
    echo "Seeding database" >&2
    /var/www/html/bin/cake migrations seed
fi

echo "Starting apache2" >&2
exec apache2ctl -DFOREGROUND
