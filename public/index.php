<?php
define('ROOT', dirname(__DIR__));

require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

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

    ->get('/test', 'test', 'test')
    // Run
    ->run();