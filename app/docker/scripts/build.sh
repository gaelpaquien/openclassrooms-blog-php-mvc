#!/bin/bash

cd /var/www

echo "Starting building app..."

if [ ! -f .env.local ]; then
  echo "Creating .env.local from .env..."
  cp .env .env.local || exit 1
fi

echo "Waiting for database..."
while ! nc -z mysql 3306; do
  echo "Waiting for MySQL to be ready..."
  sleep 1
done
echo "Database is ready!"

echo "Installing dependencies..."
composer install || exit 1

echo "Building app completed successfully!"

exec "$@"