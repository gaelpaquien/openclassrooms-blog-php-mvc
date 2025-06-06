#!/bin/bash

cd /var/www

echo "Starting building app..."

if [ ! -f .env.local ]; then
  echo "Creating .env.local from .env..."
  cp .env .env.local || exit 1
fi

echo "Installing dependencies..."
composer install || exit 1

source .env.local

echo "Waiting for MySQL to be ready..."
until nc -z ${DATABASE_HOST} 3306; do
  echo "MySQL not ready, waiting..."
  sleep 2
done

echo "Setting up database..."
php -r "
\$pdo = new PDO('mysql:host=${DATABASE_HOST}', '${MYSQL_USER}', '${MYSQL_PASSWORD}');
\$pdo->exec('CREATE DATABASE IF NOT EXISTS \`${MYSQL_DATABASE}\`');
echo 'Database created successfully\n';
"

echo "Initializing database with SQL script..."
php -r "
\$pdo = new PDO('mysql:host=${DATABASE_HOST};dbname=${MYSQL_DATABASE}', '${MYSQL_USER}', '${MYSQL_PASSWORD}');
\$sql = file_get_contents('app/docker/scripts/init-db.sql');

\$sql = preg_replace('/--.*$/m', '', \$sql);
\$sql = preg_replace('/\/\*.*?\*\//s', '', \$sql);
\$sql = preg_replace('/^\s*$/m', '', \$sql);

\$queries = explode(';', \$sql);
foreach (\$queries as \$query) {
    \$query = trim(\$query);
    if (!empty(\$query)) {
        try {
            \$pdo->exec(\$query);
        } catch (Exception \$e) {
            echo 'Query failed: ' . \$e->getMessage() . \"\n\";
            echo 'Query: ' . \$query . \"\n\";
        }
    }
}
echo 'Database initialized successfully\n';
"

echo "Building app completed successfully!"

exec "$@"