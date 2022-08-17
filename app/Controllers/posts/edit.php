<?php
use App\Core\Templating;
use App\Models\Post\PostManagement;

$postData = new PostManagement;
$post = $postData->find($params['id']);

$twig = new Templating;
$twig->view('pages/posts/edit.html.twig', ['post' => $post]);