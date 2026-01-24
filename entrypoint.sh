#!/bin/sh
set -e

# Wait for the database to be ready
# This is a simple loop, in a real production scenario a more robust solution like wait-for-it.sh might be used.
# However, the healthcheck in docker-compose.yml is the primary mechanism for this.

echo "Running database migrations..."
php artisan migrate --force

# Execute the command passed to this script (the Dockerfile's CMD)
exec "$@"
