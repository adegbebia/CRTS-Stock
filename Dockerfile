# ===================================================================
# CRTS-Stock — Dockerfile multi-stage
# Etapes 1 et 2 (build) ont besoin d'internet pour telecharger les
# dependances (npm, composer). Une fois l'image construite, le
# conteneur final tourne sans aucune connexion internet.
# ===================================================================

# --- Etape 1 : build des assets front (Vite/Tailwind/DaisyUI/etc.) ---
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY resources ./resources
COPY vite.config.js ./
COPY public ./public
RUN npm run build

# --- Etape 2 : dependances PHP (composer) ---
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-interaction \
    --prefer-dist \
    --ignore-platform-reqs

# --- Etape 3 : image finale, autonome, sans internet ---
# Base Debian (pas Alpine) : les paquets TeX Live via apt sont fiables et
# identiques a ceux testes en local (texlive-latex-extra, lang-french...),
# contrairement aux paquets texlive d'Alpine qui sont fragmentes.
FROM php:8.2-cli-bookworm AS app

# Extensions PHP requises par Laravel + SQLite, et TeX Live pour la
# generation des rapports PDF (pdflatex, appele par RapportProduitController
# et RapportArticleController).
RUN apt-get update && apt-get install -y --no-install-recommends \
        libsqlite3-dev \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        texlive-latex-base \
        texlive-latex-recommended \
        texlive-latex-extra \
        texlive-lang-french \
        texlive-fonts-recommended \
        lmodern \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        bcmath \
        intl \
        mbstring \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    # Regenere la base de noms de fichiers de kpathsea (ls-R). Sans ca,
    # pdflatex peut ne pas "voir" des fichiers pourtant bien installes sur
    # le disque (ex: lmodern.sty), car ils sont indexes dans un cache qui
    # n'est pas toujours regenere automatiquement pendant un `apt install`
    # execute dans un conteneur Docker.
    && mktexlsr

WORKDIR /var/www/html

# Code de l'application
COPY . .

# Vendor PHP (composer) construit a l'etape "vendor"
COPY --from=vendor /app/vendor ./vendor

# Assets front compiles (etape "assets") — plus besoin de CDN
COPY --from=assets /app/public/build ./public/build

# Supprime tout cache de decouverte de packages venu de l'hote (genere
# avec les dependances dev) puis le regenere a partir du VRAI vendor
# (--no-dev) present dans l'image. Sans ca, Laravel peut referencer un
# package de dev absent ici (ex: laravel/pail) et planter au demarrage.
RUN rm -f bootstrap/cache/*.php \
    && php artisan package:discover --ansi

# Permissions Laravel
RUN mkdir -p storage/framework/{cache,sessions,testing,views} storage/logs bootstrap/cache storage/app/rapports \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000
ENTRYPOINT ["/entrypoint.sh"]
