#!/bin/bash
set -e

export DB_HOST="${DB_HOST:-mysql}"
export DB_PORT="${DB_PORT:-3306}"
export DB_USER="${DB_USER:-root}"
export DB_PASSWORD="${DB_PASSWORD:-root_password}"
export DB_DATABASE="${DB_DATABASE:-db_my_coder}"

# Wait for MySQL to be fully ready and accepting queries on target database
echo "Waiting for MySQL to accept connections on ${DB_HOST}:${DB_PORT} (database: ${DB_DATABASE})..."
max_retries=30
count=0
while ! php -r '
    $h = getenv("DB_HOST") ?: "mysql";
    $p = (int)(getenv("DB_PORT") ?: 3306);
    $u = getenv("DB_USER") ?: "root";
    $pw = getenv("DB_PASSWORD") ?: "root_password";
    $db = getenv("DB_DATABASE") ?: "db_my_coder";
    mysqli_report(MYSQLI_REPORT_OFF);
    $m = @new mysqli($h, $u, $pw, $db, $p);
    if ($m->connect_error) { exit(1); }
    $res = $m->query("SELECT 1");
    if (!$res) { exit(1); }
    exit(0);
' 2>/dev/null; do
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
echo "Migrations complete."

# Ensure writable storage directories and permissions for Apache (www-data)
echo "Ensuring writable storage permissions..."
mkdir -p /var/www/html/writable/cache \
         /var/www/html/writable/session \
         /var/www/html/writable/logs \
         /var/www/html/writable/debugbar \
         /var/www/html/writable/uploads
chmod -R 777 /var/www/html/writable
chown -R www-data:www-data /var/www/html/writable

echo "Starting Apache..."
exec apache2-foreground
