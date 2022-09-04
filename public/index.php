<?php

use App\Helpers\Whoops;
use App\Core\Router;

// Define constant for the root path of the project
define('ROOT', dirname(__DIR__));

// Require Autoloader to load the \App namespace
require_once ROOT . '/vendor/autoload.php';

// Starts Whoops to display errors during development
$whoops = new Whoops;
$whoops->run();

// Start Router
$router = new Router;
$router
    // Home
    ->get('/', 'MainController@home', 'home')
    ->post('/contact', 'MainController@homeContact', 'home_contact')
    // Articles
    ->get('/article/creation', 'ArticlesController@create', 'article_create')
    ->post('/article/creation/confirmation', 'ArticlesController@create', 'article_create_confirm')
    ->get('/articles', 'ArticlesController@index', 'articles')
    ->get('/article/[*:slug]/[i:id]', 'ArticlesController@show', 'article_show')
    ->get('/article/[*:slug]/[i:id]/edition', 'ArticlesController@update', 'article_update')
    ->post('/article/[*:slug]/[i:id]/edition/confirmation', 'ArticlesController@update', 'article_update_confirm')
    ->get('/article/[*:slug]/[:id]/suppression', 'ArticlesController@delete', 'article_delete')
    // Auth
    ->get('/inscription', 'UsersController@signup', 'signup')
    ->get('/connexion', 'UsersController@login', 'login')
    // Administration
    ->get('/administration', 'UsersController@indexAdmin', 'admin_index')
    // Terms of Use & Privacy Policy
    ->get('/cgu', 'MainController@termsOfUse', 'terms_of_use')
    ->get('/politique-de-confidentialite', 'MainController@privacyPolicy', 'privacy_policy')

    // Start Router
    ->start();