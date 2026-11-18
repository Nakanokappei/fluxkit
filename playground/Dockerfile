# Image that runs the throwaway Laravel app for viewing and fixing fluxkit components on their own (PHP + Composer + Node).
FROM php:8.5-cli-trixie

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer/composer:2-bin /composer /usr/bin/composer
COPY --from=node:22-trixie /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22-trixie /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx
