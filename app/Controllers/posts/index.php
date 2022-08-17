<?php
use App\Core\Templating;
use App\Models\Post\PostManagement;

$postsData = new PostManagement;
$posts = $postsData->findAll();

$twig = new Templating;
$twig->view('pages/posts/index.html.twig', ['posts' => $posts]);