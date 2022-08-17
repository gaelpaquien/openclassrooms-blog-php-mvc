<?php

use App\Models\Old\ArticleManagement;

$article = new ArticleManagement;
$article->delete($params['id']);

header('Location: ' . $router->url('articles'));