<?php
// Define constant for root path of project
define('ROOT', dirname(__DIR__));

// Autoload
require_once ROOT . '/vendor/autoload.php';

// Start session if is not
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load Dotenv (.env -> $_ENV)
$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

// Start Whoops to display errors during development
// $whoops = new App\Helpers\Whoops;
// $whoops->run();

// Start Router
$router = new App\Core\Router;
$router
    // Home
    ->get('/', 'MainController@home', 'home')
    ->post('/contact/enregistrement', 'MainController@homeContact', 'home_contact_post')
    // Terms of Use
    ->get('/cgu', 'MainController@termsOfUse', 'terms_of_use')
    // Error
    ->get('/erreur/page-introuvable', 'MainController@errorNotFound', 'error_404')
    ->get('/erreur/acces-interdit', 'MainController@errorForbidden', 'error_forbidden')
    // User
    ->get('/inscription', 'UserController@signup', 'signup')
    ->post('/inscription/enregistrement', 'UserController@signup', 'signup_post')
    ->get('/connexion', 'UserController@login', 'login')
    ->post('/connexion/enregistrement', 'UserController@login', 'login_post')
    ->get('/deconnexion', 'UserController@logout', 'logout')
    ->get('/utilisateur/[i:id]/suppression', 'UserController@delete', 'user_delete')
    // Admin
    ->get('/administration', 'AdminController@index', 'admin_index')
    ->get('/administration/commentaires', 'AdminController@indexComments', 'admin_comments_index')
    ->get('/administration/utilisateurs', 'AdminController@indexUsers', 'admin_users_index')
    // Article
    ->get('/articles', 'ArticleController@index', 'articles')
    ->get('/article/[*:slug]/[i:id]', 'ArticleController@show', 'article_show')
    ->get('/article/creation', 'ArticleController@create', 'article_create')
    ->post('/article/creation/enregistrement', 'ArticleController@create', 'article_create_post')
    ->get('/article/[*:slug]/[i:id]/edition', 'ArticleController@update', 'article_update')
    ->post('/article/[*:slug]/[i:id]/edition/enregistrement', 'ArticleController@update', 'article_update_post')
    ->get('/article/[*:slug]/[:id]/suppression', 'ArticleController@delete', 'article_delete')
    // Comment
    ->post('/article/[*:slug]/[i:id]/commentaire/enregistrement', 'CommentController@create', 'comment_create')
    ->get('/commentaire/[i:id]/validation', 'CommentController@validation', 'comment_validate')
    ->get('/commentaire/[i:id]/suppression', 'CommentController@delete', 'comment_delete')
    // Start Router
    ->start();
