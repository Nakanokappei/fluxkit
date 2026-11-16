#!/bin/sh
# プレイグラウンドの Laravel (playground/app。git には入れない) を作る。コンテナの中で走る。
#
# - fluxkit は composer の path リポジトリ (/fluxkit。リポジトリの直下) を symlink で読む。部品を直せばすぐ効く
# - Tailwind v4 は fluxkit のビューを直に @source で拾い、fluxkit.css と fluxkit.js も直に読む (Vite の開発サーバー)
# 作り直すときは playground/app を消して、もう一度 docker compose up。
set -eu
cd /fluxkit/playground

composer create-project laravel/laravel app --no-interaction --prefer-dist
cd app

composer config repositories.fluxkit '{"type": "path", "url": "/fluxkit", "options": {"symlink": true}}'
composer require --no-interaction livewire/livewire:^4.1 livewire/flux:^2.13 'cc9/fluxkit:*@dev'

# プレビューのルートを開く (config fluxkit.preview.enabled)。画面は日本語 (部品の文の鍵のまま)。セッションなどは DB を使わない。
sed -i 's/^APP_LOCALE=.*/APP_LOCALE=ja/' .env
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
