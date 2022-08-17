<?php
use App\Core\Templating;
use App\Models\Post\PostManagement;

$data = new PostManagement;
$posts = $data->findAll(3);

$twig = new Templating;
$twig->view('pages/home.html.twig', ['posts' => $posts]);