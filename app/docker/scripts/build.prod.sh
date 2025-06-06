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

echo "DEBUG: DATABASE_HOST=${DATABASE_HOST}"
echo "DEBUG: MYSQL_USER=${MYSQL_USER}"
echo "DEBUG: MYSQL_DATABASE=${MYSQL_DATABASE}"
echo "DEBUG: MYSQL_PASSWORD=${MYSQL_PASSWORD}"

echo "Waiting for MySQL to be ready..."
until mysqladmin ping -h ${DATABASE_HOST} -u ${MYSQL_USER} --password=${MYSQL_PASSWORD} --silent; do
  echo "MySQL not ready, waiting..."
  sleep 2
done

echo "Setting up database..."
mysql -h ${DATABASE_HOST} -u ${MYSQL_USER} --password=${MYSQL_PASSWORD} \
  -e "CREATE DATABASE IF NOT EXISTS ${MYSQL_DATABASE};"

if [ -f app/docker/scripts/init-db.sql ]; then
  echo "Initializing database..."
  mysql -h ${DATABASE_HOST} -u ${MYSQL_USER} --password=${MYSQL_PASSWORD} ${MYSQL_DATABASE} < app/docker/scripts/init-db.sql
fi

echo "Building app completed successfully!"

exec "$@"