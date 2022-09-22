<?php

use App\Helpers\Whoops;
use App\Core\Router;

// Start session if is not
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define constant for root path of project
define('ROOT', dirname(__DIR__));

// Require Autoloader to load \App namespace
require_once ROOT . '/vendor/autoload.php';

// Starts Whoops to display errors during development
$whoops = new Whoops;
$whoops->run();

// Start Router
$router = new Router;
$router
    // Home
    ->get('/', 'MainController@home', 'home')
    ->post('/contact/enregistrement', 'MainController@homeContact', 'home_contact_post')
    // Terms of Use & Privacy Policy
    ->get('/cgu', 'MainController@termsOfUse', 'terms_of_use')
    ->get('/politique-de-confidentialite', 'MainController@privacyPolicy', 'privacy_policy')
    // Errors 
    ->get('/erreur/page-introuvable', 'MainController@errorNotFound', 'error_404')
    ->get('/erreur/acces-interdit', 'MainController@errorForbidden', 'error_forbidden')
    // Authentication
    ->get('/inscription', 'UsersController@signup', 'signup')
    ->post('/inscription/enregistrement', 'UsersController@signup', 'signup_post')
    ->get('/connexion', 'UsersController@login', 'login')
    ->post('/connexion/enregistrement', 'UsersController@login', 'login_post')
    ->get('/deconnexion', 'UsersController@logout', 'logout')
    // Administration
    ->get('/administration', 'UsersController@adminIndex', 'admin_index')
    ->get('/administration/commentaires', 'CommentsController@adminComments', 'admin_comments')
    // Articles
    ->get('/articles', 'ArticlesController@index', 'articles')
    ->get('/article/[*:slug]/[i:id]', 'ArticlesController@show', 'article_show')
    ->get('/article/creation', 'ArticlesController@create', 'article_create')
    ->post('/article/creation/enregistrement', 'ArticlesController@create', 'article_create_post')
    ->get('/article/[*:slug]/[i:id]/edition', 'ArticlesController@update', 'article_update')
    ->post('/article/[*:slug]/[i:id]/edition/enregistrement', 'ArticlesController@update', 'article_update_post')
    ->get('/article/[*:slug]/[:id]/suppression', 'ArticlesController@delete', 'article_delete')
    // Comments
    ->post('/article/[*:slug]/[i:id]/commentaire/enregistrement', 'CommentsController@create', 'comment_create')
    ->get('/commentaire/[i:id]/suppression', 'CommentsController@delete', 'comment_delete')
    ->get('/commentaire/[i:id]/validation', 'CommentsController@validComment', 'comment_validate')
    // Start Router
    ->start();
