<?php
require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new AltoRouter();

$router->map('GET', '/', 'home', 'home');
$router->map('GET', '/articles', 'posts/index', 'articles');
$router->map('GET', '/article/[i:id]', 'posts/post', 'article');
$router->map('POST', '/article/update/[i:id]', 'posts/update', 'update_article');

$match = $router->match();

if(is_array($match)) {
    if (is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    } else {
        $params = $match['params'];
        require "../app/Controllers/{$match['target']}.php";
    }
} else {
    require "../app/Views/error404.php";
}