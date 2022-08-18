<?php
use App\Controllers\Helpers\Date;
use App\Controllers\Helpers\Text;
use App\Models\Old\ArticleManagement;

$slug = new Text;

$dateNow = new Date;
$date = $dateNow->getDateNow();

$article = new ArticleManagement;
$article->create([
    'id' => 4,
    'title' => $_POST['title'],
    'slug' => $slug->slugify($_POST['title']),
    'caption' => $_POST['caption'],
    'content' => $_POST['content'],
    'author_id' => 1,
    'created_at' => $date,
    'updated_at' => $date,
    'picture' => null
]);

header('Location: ' . $router->url('articles'));