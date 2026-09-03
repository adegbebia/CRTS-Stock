#!/bin/sh
set -e

echo "[entrypoint] Demarrage du conteneur CRTS-Stock..."
cd /var/www/html

echo "[entrypoint] Verification de la cle d'application..."
if ! grep -q "^APP_KEY=base64:" .env 2>/dev/null; then
    echo "[entrypoint] Aucune cle valide trouvee, generation..."
    php artisan key:generate --force
else
    echo "[entrypoint] Cle d'application deja presente."
fi

echo "[entrypoint] Verification de la base sqlite..."
touch database/database.sqlite

echo "[entrypoint] Execution des migrations..."
php artisan migrate --force

echo "[entrypoint] Lien de stockage public..."
php artisan storage:link || true

echo "[entrypoint] Mise en cache config/routes/vues..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=================================================="
echo " CRTS-Stock est pret : http://localhost:8000"
echo " (aucune connexion internet requise a partir d'ici)"
echo "=================================================="

exec php artisan serve --host=0.0.0.0 --port=8000
