<?php

use App\Controllers\Helpers\Whoops;
use App\Core\Router;

// Define 'ROOT' for the root path of the project
define('ROOT', dirname(__DIR__));

// Require Autoloader to load the \App namespace
require_once ROOT . '/vendor/autoload.php';

// Starts Whoops to display errors during development
$whoops = new Whoops;
$whoops->run();


// Start router
$router = new App\Core\Router();
$router
    // Home
    ->get('/', 'old/home', 'home')
    // Articles
    ->get('/articles', 'old/articles/index', 'articles')
    ->get('/article/[*:slug]-[i:id]', 'old/articles/article', 'article')
    ->get('/article/creation', 'old/articles/create', 'article_create')
    ->post('/article/creation/confirmer', 'old/articles/createConfirm')
    ->get('/article/[*:slug]-[i:id]/edition', 'old/articles/edit', 'article_edit')
    ->post('/article/[*:slug]-[i:id]/edition/confirmer', 'old/articles/editConfirm', 'article_edit_confirm')
    ->get('/article/[*:slug]-[i:id]/suppression', 'old/articles/delete', 'article_delete')

    ->get('/test', 'old/test', 'test')
    // Run
    ->run();