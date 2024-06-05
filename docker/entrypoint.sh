#!/bin/bash

# Run migrations
php artisan migrate --force

# Start supervisord
exec "$@"

