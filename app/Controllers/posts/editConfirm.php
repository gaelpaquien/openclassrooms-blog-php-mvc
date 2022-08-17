<?php

use App\Controllers\Helpers\Date;
use App\Models\Post\PostManagement;

$dateNow = new Date;
$date = $dateNow->getDateNow();

$post = new PostManagement;
$post->update([
    'title' => $_POST['title'], 
    'short_description' => $_POST['shortDescription'],
    // 'user_id' => $_POST['author'],
    'content' => $_POST['message'],
    'last_update' => $date
], $params['id']);

header('Location: ' . $router->url('posts'));