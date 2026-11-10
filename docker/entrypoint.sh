#!/bin/sh
set -e

cd /var/www/html

if [ ! -d vendor ]; then
  composer install --no-interaction --prefer-dist --ignore-platform-reqs
fi

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache || true

if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
  php artisan key:generate --force || true
fi

i=0
until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); exit(0);} catch (Exception \$e) { exit(1);}" 2>/dev/null; do
  i=$((i+1))
  if [ "$i" -gt 60 ]; then
    echo "MySQL not ready after waiting"
    break
  fi
  echo "Waiting for MySQL... ($i)"
  sleep 2
done

READY=$(php -r "try { \$p=new PDO('mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); \$n=\$p->query(\"SELECT COUNT(*) FROM information_schema.tables WHERE table_schema=DATABASE() AND table_name='users'\")->fetchColumn(); echo (\$n>0)?'1':'0'; } catch (Exception \$e) { echo '0'; }")

if [ "$READY" != "1" ]; then
  echo "Bootstrapping schema and seed..."
  php artisan migrate --force
  php artisan db:seed --force
else
  echo "Database already initialized — skipping migrate/seed"
fi

php artisan storage:link || true

if [ ! -f public/css/filament/filament/app.css ]; then
  php artisan filament:assets || true
fi

exec "$@"