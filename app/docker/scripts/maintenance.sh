#!/bin/bash
set -e

log() {
    echo "[$(date '+%H:%M:%S')] $1"
}

log "START: Maintenance blogphpmvc"

log "Cleaning images added in the last 24 hours"
UPLOADS_PATH="public/assets/img/articles"
if [[ -d "$UPLOADS_PATH" ]]; then
    DELETED_COUNT=$(find "$UPLOADS_PATH" -type f -mtime -1 -delete -print | wc -l)
    log "OK: $DELETED_COUNT files deleted in $UPLOADS_PATH"
fi

ENV_FILE=".env"

log "Database reset"
if [[ -f "$ENV_FILE" ]]; then
    source "$ENV_FILE"
    docker cp docker/scripts/init-db.sql mysql-shared:/tmp/init-db.sql
    docker exec mysql-shared mysql -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" < /tmp/init-db.sql
fi

log "Cleaning cache"
rm -rf tmp/cache/*

log "END: Maintenance blogphpmvc completed"