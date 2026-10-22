#!/bin/bash
set -e

export DB_HOST="${DB_HOST:-mysql}"
export DB_PORT="${DB_PORT:-3306}"
export DB_USER="${DB_USER:-root}"
export DB_PASSWORD="${DB_PASSWORD:-root_password}"

# Wait for MySQL to be fully ready (beyond just ping)
echo "Waiting for MySQL to accept connections on ${DB_HOST}:${DB_PORT}..."
max_retries=30
count=0
while ! php -r '$h = getenv("DB_HOST") ?: "mysql"; $p = getenv("DB_PORT") ?: "3306"; $u = getenv("DB_USER") ?: "root"; $pw = getenv("DB_PASSWORD") ?: "root_password"; new PDO("mysql:host={$h};port={$p}", $u, $pw);' 2>/dev/null; do
    count=$((count + 1))
    if [ $count -ge $max_retries ]; then
        echo "ERROR: MySQL did not become ready in time. Starting Apache without migrations."
        exec apache2-foreground
    fi
    echo "MySQL not ready yet... retrying ($count/$max_retries)"
    sleep 2
done

echo "MySQL is ready!"

# Run migrations (safe to run multiple times — only applies pending migrations)
echo "Running database migrations..."
cd /var/www/html
php spark migrate --all 2>&1 || echo "WARNING: Migration encountered an issue. Check logs."

echo "Migrations complete. Starting Apache..."
exec apache2-foreground
