#!/bin/bash

## Taken from the docker-compose docs:  https://docs.docker.com/compose/startup-order/

set -e

host="$1"
shift
cmd=("$@")

until PGPASSWORD=$PHPRECIPEBOOK_DB_PASS psql -h "${PHPRECIPEBOOK_DB_HOST}" -U "${PHPRECIPEBOOK_DB_LOGIN}" -c '\q'; do
  >&2 echo "Postgres is unavailable - sleeping"
  sleep 1
done

>&2 echo "Postgres is up - executing $cmd"

if [[ ${#cmd[@]} > 0 ]]; then
  exec "${cmd[@]}"
fi
