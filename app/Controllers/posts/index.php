<?php
use App\Core\Templating;
use App\Models\Posts;

$postsData = new Posts;
$posts = $postsData->findAll();

$twig = new Templating;
$twig->view('pages/posts/index.html.twig', ['posts' => $posts]);

require(ROOT . '/app/Views/posts/index.php');
