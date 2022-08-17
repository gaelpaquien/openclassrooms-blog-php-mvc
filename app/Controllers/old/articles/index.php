<?php
use App\Core\Templating;
use App\Models\Old\ArticleManagement;

$articlesData = new ArticleManagement;
$articles = $articlesData->findAll();

$twig = new Templating;
$twig->view('pages/articles/index.html.twig', ['articles' => $articles]);