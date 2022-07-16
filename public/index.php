<?php
require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new AltoRouter();

$router->map('GET', '/', 'home', 'home');
$router->map('GET', '/contact', 'contact', 'contact');
$router->map('GET', '/article/[*:slug]-[i:id]', 'article', 'article');

$match = $router->match();

if(is_array($match)) {
    if (is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    } else {
        $params = $match['params'];
        require "../src/templates/{$match['target']}.php";
    }
} else {
    require "../src/templates/error404.php";
}