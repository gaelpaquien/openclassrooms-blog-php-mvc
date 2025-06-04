#!/bin/bash

# Set working directory
# cd /path/to/project

# Start of script
echo "maintenance.sh: Start of daily maintenance script"

# Delete images added in the last 24 hours (including subdirectories)
echo "maintenance.sh: Delete images added in the last 24 hours (including subdirectories)"
find "$PWD/public/assets/img/articles" -type f -mtime -1 -print -exec rm {} \;

# Set path to .env file
ENV_FILE=".env"

# Load environment variables from .env
if [ -f "$ENV_FILE" ]; then
    echo "maintenance.sh: Loading environment variables from $ENV_FILE"
    source "$ENV_FILE"
fi

# Database reset
echo "maintenance.sh: Database reset"
mysql -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" -h "$DATABASE_HOST" "$MYSQL_DATABASE" < init-db.sql

# Delete temporary files
echo "maintenance.sh: Delete temporary files"
rm -rf tmp/cache/*

# Send a confirmation email
# subject="Blog PHP MVC - Daily maintenance"
# message="The daily maintenance script completed successfully."
# recipient="your@email.com"
# echo "$message" | mail -s "$subject" "$recipient"

# End of script
echo "maintenance.sh: All steps are completed, end of daily maintenance script"
