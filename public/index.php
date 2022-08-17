<?php
define('ROOT', dirname(__DIR__));

require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new App\Core\Router();
$router
    // Home
    ->get('/accueil', '/home', 'home')
    // Posts
    ->get('/articles', '/posts/index', 'posts')
    ->get('/article/[*:slug]-[i:id]', '/posts/post', 'post')
    ->get('/article/creation', 'posts/create', 'post_create')
    ->post('/article/creation/confirmer', 'posts/createConfirm')
    ->get('/article/[*:slug]-[i:id]/edition', 'posts/edit', 'post_edit')
    ->post('/article/[*:slug]-[i:id]/edition/confirmer', 'posts/editConfirm', 'post_edit_confirm')
    ->get('/article/[*:slug]-[i:id]/suppression', 'posts/delete', 'post_delete')
    // Run
    ->run();