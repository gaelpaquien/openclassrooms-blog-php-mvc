<?php
use App\Core\Templating;
use App\Models\Old\ArticleManagement;

$articleData = new ArticleManagement;
$article = $articleData->find($params['id']);

$twig = new Templating;
$twig->view('pages/articles/edit.html.twig', ['article' => $article]);