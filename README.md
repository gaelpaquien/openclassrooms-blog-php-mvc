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
2. SMTP (*example: [maildev](https://github.com/maildev/maildev)*) (*SMTP is already included if you are using docker*)


### Installation
1. **Clone the repository on the main branch**

2. **Create the .env.local file and replace the values of the .env origin file**
```bash
###> app ###
DB_HOST=#database_host#
DB_NAME=#database_name#
DB_USER=#database_user#
DB_PASSWORD=#database_user_password#
MAIL_CONTACT=#mail_contact#
###< app ###

###> docker/database ###
DATABASE_HOST=#database_host#
MYSQL_DATABASE=#database_name#
MYSQL_ROOT_PASSWORD=#database_root_password#
MYSQL_USER=#database_user#
MYSQL_PASSWORD=#database_user_password#
MYSQL_DATABASE_TEST=#database_test_name#
###< docker/database ###
```

3. **If you are using docker, install your environment**
```bash
docker-compose up --build -d
```

4. **Installing dependencies**
```bash
composer install
```

5. **Setting up the database with the init-db.sql file**<br>
*If you are using docker, the database "training_blog" is already created with the data at localhost:3310*

1. **Start the project**
```bash
php -S 127.0.0.1:8080 -t public
```
*If you are using docker, the project is already accessible at http://localhost:8080*

--- --- ---

### Links
[Website](https://formation.blog.gaelpaquien.com/)\
[Codacy Review](https://app.codacy.com/gh/Galuss1/openclassrooms-blog/dashboard)
