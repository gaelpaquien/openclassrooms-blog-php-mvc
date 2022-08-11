<?php
define('ROOT', dirname(__DIR__));

require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new App\Core\Router();
$router
    // Home
    ->get('/', '/home', 'home')
    // Posts
    ->get('/articles', '/posts/index', 'articles')
    ->get('/article/[i:id]', '/posts/post', 'article')
    ->post('/article/update/[i:id]', 'posts/update', 'update_article')
    // Run
    ->run();
