#!/bin/sh

set -o errexit
set -o nounset

# Wait for database to be ready
echo "Waiting for database..." >&2
until php -r "new PDO(getenv('DATABASE_URL'));" >/dev/null 2>&1; do
    sleep 1
done

# Run seed if requested. Unless using a version of Cake that
# avoics duplicate seeding, it's better to do this manually.
if [ "${PHPRB_INSERT_SEEDS:-}" = "true" ]; then
    echo "Seeding database" >&2
    /var/www/html/bin/cake migrations seed
fi

echo "Starting apache2" >&2
exec apache2ctl -DFOREGROUND
