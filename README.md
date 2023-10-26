# OpenClassrooms - Create your first blog in PHP

## Repository containing the context and deliverables of the project
https://github.com/Galuss1/openclassrooms-archive/tree/main/php-symfony-application-developer/project-5

## Setting up

### Required
1. [PHP 8.0](https://www.php.net/downloads.php)
2. [Composer](https://getcomposer.org/download/)
3. [MySQL](https://www.mysql.com/fr/downloads/)

### Optional
1. [Docker](https://www.docker.com/)
2. SMTP (*SMTP is already included if you are using docker*)


### Installation
1. **Clone the repository on the main branch**

2. **Create the .env.local file and replace the values of the .env origin file**
```bash
###> smtp ###
SMTP_HOST=#smtp_host# (docker default: mailhog)
SMTP_PORT=#smtp_port# (docker default: 1025)
SMTP_MAIL_TO=#smtp_mail_to#
###< smtp ###

###> database ###
DATABASE_HOST=#database_host#
MYSQL_DATABASE=#database_name#
MYSQL_USER=#database_user#
MYSQL_PASSWORD=#database_user_password#
MYSQL_ROOT_PASSWORD=#database_root_password# (not required if you don't use docker)
MYSQL_DATABASE_TEST=#database_test_name# (not required, can be used if you use docker)
###< database ###
```

3. **Only if you are using Docker, environment installation**
```bash
docker-compose up --build -d
```
Wait a few moments for the environment to fully install.\
The website is accessible at http://localhost:8080\
Mailhog is accessible at http://localhost:8025\
The database was created with data at localhost:3310\
Your installation is complete, you do not need to follow the next steps.

4. **Installing dependencies**
```bash
composer install
```

5. **Setting up the database with the init-db.sql file**

6. **Start the project**
```bash
php -S 127.0.0.1:8080 -t public
```

--- --- ---

### Links
[Website](https://formation.blog.gaelpaquien.com/)\
[Codacy Review](https://app.codacy.com/gh/Galuss1/openclassrooms-blog/dashboard)
