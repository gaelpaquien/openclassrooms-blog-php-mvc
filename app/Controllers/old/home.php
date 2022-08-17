<?php
use App\Core\Templating;
use App\Models\Old\ArticleManagement;

$data = new ArticleManagement;
$articles = $data->findAll(3);

$twig = new Templating;
$twig->view('pages/home.html.twig', ['articles' => $articles]);