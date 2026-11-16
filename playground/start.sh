#!/bin/sh
# プレイグラウンドを起こす (コンテナの中で走る)。最初の 1 回は setup.sh で Laravel を作る。
set -eu
cd /fluxkit/playground
[ -f app/artisan ] || sh ./setup.sh
cd app
php artisan view:clear > /dev/null
php artisan serve --host=0.0.0.0 --port=8000 &
exec npm run dev -- --host 0.0.0.0
