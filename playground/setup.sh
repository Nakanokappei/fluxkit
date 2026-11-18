#!/bin/sh
# Creates the playground's Laravel app (playground/app, not committed). Runs inside the container.
#
# - fluxkit is loaded from a composer path repository (/fluxkit, the repository root) via symlink, so component edits apply immediately
# - Tailwind v4 picks up fluxkit's views directly via @source, and fluxkit.css and fluxkit.js are read directly too (Vite dev server)
# To rebuild, delete playground/app and run docker compose up again.
set -eu
cd /fluxkit/playground

composer create-project laravel/laravel app --no-interaction --prefer-dist
cd app

composer config repositories.fluxkit '{"type": "path", "url": "/fluxkit", "options": {"symlink": true}}'
composer require --no-interaction livewire/livewire:^4.1 livewire/flux:^2.13 'cc9/fluxkit:*@dev'

# Enable the preview route (config fluxkit.preview.enabled). Sessions and the like do not use a DB.
# Set APP_LOCALE=ja in playground/app/.env to check the Japanese translations (lang/ja.json).
cat >> .env <<'ENV'

FLUXKIT_PREVIEW=true
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
ENV

cp ../stubs/app.css resources/css/app.css
cp ../stubs/app.js resources/js/app.js
cp ../stubs/vite.config.js vite.config.js

npm install --no-audit --no-fund
echo "[setup] done"
