<?php

use App\Controllers\Helpers\Date;
use App\Controllers\Helpers\Text;
use App\Models\Old\ArticleManagement;

$slug = new Text;

$dateNow = new Date;
$date = $dateNow->getDateNow();

$article = new ArticleManagement;
$article->update([
    'title' => $_POST['title'], 
    'slug' => $slug->slugify($_POST['title']),
    'caption' => $_POST['caption'],
    // 'author_id' => $_POST['author'],
    'content' => $_POST['message'],
    'updated_at' => $date
], $params['id']);

header('Location: ' . $router->url('articles'));