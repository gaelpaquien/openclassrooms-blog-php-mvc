<?php

use App\Models\Post\PostManagement;

$post = new PostManagement;
$post->delete($params['id']);

header('Location: ' . $router->url('posts'));