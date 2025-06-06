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

MYSQL_DSN="-h ${DATABASE_HOST} -u ${MYSQL_USER} --password=${MYSQL_PASSWORD}"

echo "Waiting for MySQL to be ready..."
until mysql ${MYSQL_DSN} -e "SELECT 1" &> /dev/null; do
  echo "MySQL not ready, waiting..."
  sleep 2
done

echo "Setting up database..."
mysql ${MYSQL_DSN} -e "CREATE DATABASE IF NOT EXISTS ${MYSQL_DATABASE};"
mysql ${MYSQL_DSN} ${MYSQL_DATABASE} < app/docker/scripts/init-db.sql

echo "Building app completed successfully!"

exec "$@"