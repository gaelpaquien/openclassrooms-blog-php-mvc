<?php
require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new AltoRouter();

$router->map('GET', '/', 'home', 'home');
$router->map('GET', '/articles', 'post/index', 'articles');
$router->map('GET', '/article/[i:id]', 'post/post', 'article');
$router->map('GET', '/article/update', 'post/update', 'update_article');

$match = $router->match();

if(is_array($match)) {
    if (is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    } else {
        $params = $match['params'];
        require "../src/views/{$match['target']}.php";
    }
} else {
    require "../src/views/error404.php";
}