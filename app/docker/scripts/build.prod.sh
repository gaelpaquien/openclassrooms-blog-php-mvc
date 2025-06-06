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
"
php -r "
// Initialize the database with the provided SQL file
\$pdo = new PDO('mysql:host=${DATABASE_HOST};dbname=${MYSQL_DATABASE}', '${MYSQL_USER}', '${MYSQL_PASSWORD}');
\$sql = file_get_contents('./docker/scripts/init-db.sql');

// Disable foreign key checks to avoid issues with existing tables
\$pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');

// Remove comments and empty lines from SQL
\$sql = preg_replace('/--.*$/m', '', \$sql);
\$sql = preg_replace('/\/\*.*?\*\//s', '', \$sql);
\$sql = preg_replace('/^\s*$/m', '', \$sql);

// Split SQL into individual queries
\$queries = explode(';', \$sql);

// Execute each query
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

// Re-enable foreign key checks
\$pdo->exec('SET FOREIGN_KEY_CHECKS = 1;');
"
echo "Database setup completed."

echo "Building app completed successfully!"

exec "$@"