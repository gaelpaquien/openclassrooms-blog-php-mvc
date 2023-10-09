# PHP/Symfony application developer - OpenclassRooms (Project 5)

## Create your first blog in PHP

### Skills assessed:
1. Choose a suitable technical solution from among the existing solutions.
2. Manage your data with a database.
3. Write the detailed specifications of the project.
4. Ensure the quality follow-up of a project.
5. Estimate a task and meet deadlines.
6. Conceptualize the whole application by describing its structure (Entities / Domain Objects).
7. Propose a clean and easily scalable code.
8. Create a web page to collect information entered by a user.
9. Analyze a set of specifications.
10. Create and maintain the technical architecture of the site.

### Setting up the website

#### Required:
1. [PHP](https://www.php.net/downloads.php)
2. [Composer](https://getcomposer.org/download/) to install the dependencies PHP.
3. [MySQL](https://www.mysql.com/fr/downloads/)
4. SMTP configuration if you want to send emails from the contact form.
5. Create an .env file like the example below and replace the values.

##### Example of the .env file:
> DB_HOST="Indicate the host of your database here."\
> DB_NAME="Indicate the name of your database here."\
> DB_USER="Indicate the username of your database here."\
> DB_PASSWORD="Indicate the password of your database here."\
> MAIL_CONTACT="Indicate here the email address that will receive the emails sent from the contact form."

#### Installation:
1. Download the GitHub repository on the main branch.
2. Use the file "db.sql" located at the root of the project to insert data and create your database.
3. Insert your .env file in the root of the project, the connection information to your database must be correct.
4. Open a command terminal at the root of the project and use the following commands:\
   4.1. **composer install** *(this command allows you to install the project's dependencies)*\
   4.2. **composer dump-autoload** *(this command allows you to update your autoloader)*
5. Launch your website. For this, there are several solutions:\
   5.1. Use a web server (MAMP, XAMPP...).\
   5.2. Launch a terminal from the root of the project and use the following command: **php -S localhost:8000 -t public**

--- --- ---

### Links
[Website](https://blog.gaelpaquien.com/)\
[Repository archive containing all deliverables](https://github.com/Galuss1/openclassrooms-archive/tree/main/php-symfony-application-developer/project-5)\
[Codacy Review](https://app.codacy.com/gh/Galuss1/openclassrooms-blog/dashboard)
