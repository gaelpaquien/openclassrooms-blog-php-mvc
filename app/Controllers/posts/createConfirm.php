<?php
use App\Controllers\Helpers\Date;
use App\Controllers\Helpers\Text;
use App\Models\Post\PostManagement;

$slug = new Text;

$dateNow = new Date;
$date = $dateNow->getDateNow();

$post = new PostManagement;
$post->create([
    'id' => 4,
    'title' => $_POST['title'],
    'slug' => $slug->slugify($_POST['title']),
    'short_description' => $_POST['shortDescription'],
    'content' => $_POST['content'],
    'user_id' => 1,
    'created_at' => $date,
    'last_update' => $date,
    'picture' => null
]);

header('Location: ' . $router->url('posts'));