<?php
require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new App\Core\Router(dirname(__DIR__) . '/app/Controllers');
$router
    // Home
    ->get('/', '/home', 'home')
    // Posts
    ->get('/articles', '/posts/index', 'articles')
    ->get('/article/[i:id]', '/posts/post', 'article')
    ->post('/article/update/[i:id]', 'posts/update', 'update_article')
    ->run();
