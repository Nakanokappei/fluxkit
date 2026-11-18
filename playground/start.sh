#!/bin/sh
# Starts the playground (runs inside the container). On first run, setup.sh creates the Laravel app.
set -eu
cd /fluxkit/playground
[ -f app/artisan ] || sh ./setup.sh
cd app
php artisan view:clear > /dev/null
php artisan serve --host=0.0.0.0 --port=8000 &
exec npm run dev -- --host 0.0.0.0
