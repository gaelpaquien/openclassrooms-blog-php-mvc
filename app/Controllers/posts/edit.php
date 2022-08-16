<?php
use App\Core\Templating;
use App\Models\Posts;

$postData = new Posts;
$post = $postData->find($params['id']);

$twig = new Templating;
$twig->view('pages/posts/edit.html.twig', ['post' => $post]);

if (isset($_POST)) {
    dump($_POST);
} else {
    echo('test');
}