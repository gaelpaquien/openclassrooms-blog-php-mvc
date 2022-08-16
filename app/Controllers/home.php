<?php
use App\Core\Templating;
use App\Models\Posts;

$data = new Posts;
$posts = $data->findAll(3);

$twig = new Templating;
$twig->view('pages/home.html.twig', [
    'posts' => $posts, 
    'urlAllPosts' => $router->url('posts')
]);

require(ROOT . '/app/Views/Home.php');
