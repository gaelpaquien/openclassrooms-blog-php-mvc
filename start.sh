# Start Apache in the foreground
apache2-foreground &

# Wait for Apache to start
sleep 5

# Log a message to indicate the start of Apache
echo "start.sh : Apache started"

# Wait for MySQL to start
until nc -z -v -w30 database 3306
do
  echo "start.sh : Waiting for MySQL to start to continue"
  sleep 5
done

# Log a message to indicate the start of MySQL
echo "start.sh : MySQL started"

# Change directory to the project root
cd /var/www/html

# Install Composer dependencies
composer install

# Log a message to indicate the end of the script
echo "start.sh : End of script execution, container ready"

# Keep container running
tail -f /dev/null
